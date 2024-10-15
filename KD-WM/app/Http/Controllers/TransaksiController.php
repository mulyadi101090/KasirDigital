<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = Transaksi::with('detailTransaksi.barang')->get();
        return response()->json([
            "success" => true,
            "message" => "Data semua transaksi",
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array', // array of items
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Buat transaksi baru
            $transaksi = Transaksi::create([
                'user_id' => $validated['user_id'],
                'total_harga' => 0, // Diupdate setelah menghitung total
            ]);

            $totalHarga = 0;

            // Looping barang yang dibeli
            foreach ($validated['items'] as $item) {
                $barang = Barang::findOrFail($item['barang_id']);
                
                // Hitung harga total untuk item ini
                $totalItemPrice = $barang->price * $item['quantity'];
                $totalHarga += $totalItemPrice;

                // Simpan detail transaksi
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barang->id,
                    'quantity' => $item['quantity'],
                    'price_per_unit' => $barang->price,
                    'total_price' => $totalItemPrice,
                ]);

                // Update stok barang
            $barang->stock -= $item['quantity'];
                $barang->save();
            }

            // Update total harga transaksi
            $transaksi->update([
                'total_harga' => $totalHarga
            ]);

            DB::commit();

            return response()->json([
                "success" => true,
                "message" => "Transaksi berhasil dilakukan",
                "data" => $transaksi->load('detailTransaksi.barang')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "success" => false,
                "message" => "Terjadi kesalahan: " . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $data = Transaksi::with('detailTransaksi.barang')->findOrFail($id);
        return response()->json([
            "success" => true,
            "message" => "Detail transaksi",
            "data" => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $transaksi = Transaksi::find($id);

        if ($transaksi) {
            // Hapus detail transaksi terkait
            TransaksiDetail::where('transaksi_id', $transaksi->id)->delete();

            // Hapus transaksi
            $transaksi->delete();

            return response()->json([
                "success" => true,
                "message" => "Transaksi berhasil dihapus",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Transaksi tidak ditemukan",
            ], 404);
        }
    }
}

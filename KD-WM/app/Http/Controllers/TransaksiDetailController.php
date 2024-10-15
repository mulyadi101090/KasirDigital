<?php

namespace App\Http\Controllers;

use App\Models\TransaksiDetail;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class TransaksiDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = TransaksiDetail::with('transaksi', 'barang')->get();
        return response()->json([
            "success" => true,
            "message" => "Data semua detail transaksi",
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|integer|min:1',
            'price_per_unit' => 'required|numeric',
            'total_price' => 'required|numeric',
        ]);

        $data = TransaksiDetail::create($validated);
        return response()->json([
            "success" => true,
            "message" => "Detail transaksi baru ditambahkan",
            "data" => $data
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $data = TransaksiDetail::with('transaksi', 'barang')->findOrFail($id);
        return response()->json([
            "success" => true,
            "message" => "Detail transaksi",
            "data" => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|integer|min:1',
            'price_per_unit' => 'required|numeric',
            'total_price' => 'required|numeric',
        ]);

        $detailTransaksi = TransaksiDetail::findOrFail($id);
        $detailTransaksi->update($validated);
        return response()->json([
            "success" => true,
            "message" => "Detail transaksi berhasil diubah",
            "data" => $detailTransaksi
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $transaksidetail = TransaksiDetail::find($id);

        if ($transaksidetail) {
            $transaksidetail->delete();

            return response()->json([
                "success" => true,
                "message" => "Detail transaksi berhasil dihapus",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Detail transaksi tidak ditemukan",
            ], 404);
        }
    }
}

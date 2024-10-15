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
        $data = Transaksi::with('user')->get();
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
            'total_harga' => 'required|numeric',
        ]);
        $data = Transaksi::create($validated);
        return response()->json([
            "success" => true,
            "message" => "Transaksi baru ditambahkan",
            "data" => $data
        ]);
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
        $transaksi = Transaksi::destroy($id);

        if ($transaksi) {
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
    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_harga' => 'required|numeric',
        ]);
        $data = Transaksi::findOrFail($id);
        $data->update($validated);
        return response()->json([
            "success" => true,
            "message" => "Transaksi berhasil diubah",
            "data" => $data
        ]);
    }
}

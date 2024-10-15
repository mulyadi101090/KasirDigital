<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = Barang::with("transaksis")->get();
        return response()->json([
            "success" => true,
            "message" => "Data semua barang",
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
       $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        "transaksi_id" => 'required|exists:transaksis,id',
         ]);

    $barang = Barang::create($validated);

    return response()->json([
        "success" => true,
        "message" => "Barang baru ditambahkan",
        "data" => $barang
    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $data = Barang::with("kategori")->findOrFail($id);
        return response()->json([
            "success" => true,
            "message" => "Data detail barang",
            "data" => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id'
        ]);

        $data = Barang::findOrFail($id);
        $data->update($validated);

        return response()->json([
            "success" => true,
            "message" => "Barang berhasil diubah",
            "data" => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $barang = Barang::destroy($id);

        if ($barang) {
            return response()->json([
                "success" => true,
                "message" => "Barang berhasil dihapus",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Barang tidak ditemukan",
            ], 404);
        }
    }
}

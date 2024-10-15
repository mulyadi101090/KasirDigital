<?php

namespace App\Http\Controllers;

use App\Models\taransaksidetail;
use Illuminate\Http\Request;

class TaransaksidetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = taransaksidetail::all();
        return response()->json([
            "success" => true,
            "message" => "Data semua detail transaksi",
            "data" => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = taransaksidetail::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|integer',
            'price_per_unit' => 'required|numeric',
            'total_price' => 'required|numeric',
        ]);
        $data = taransaksidetail::create($validated);
        return response()->json([
            "success" => true,
            "message" => "Detail transaksi ditambahkan",
            "data" => $data
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(taransaksidetail $taransaksidetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(taransaksidetail $taransaksidetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, taransaksidetail $taransaksidetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(taransaksidetail $taransaksidetail)
    {
        //
    }
}

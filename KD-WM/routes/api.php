<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TaransaksidetailController;

// Rute untuk Barang
// Route::post('/barang', [BarangController::class, 'store']);
Route::apiResource('barangs', BarangController::class);
// Rute untuk Transaksi
Route::apiResource('transaksis', TransaksiController::class);

// Rute untuk Detail Transaksi
Route::apiResource('taransaksidetails', TaransaksidetailController::class);

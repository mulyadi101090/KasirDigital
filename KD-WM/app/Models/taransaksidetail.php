<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class taransaksidetail extends Model
{
    /** @use HasFactory<\Database\Factories\TaransaksidetailFactory> */
    use HasFactory;
    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'quantity',
        'price_per_unit',
        'total_price',
    ];
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id');
    }
}

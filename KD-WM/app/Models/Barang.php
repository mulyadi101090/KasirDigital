<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'stock', 'transaksi_id'];

    /**
     * Relasi ke DetailTransaksi
     */

    public function transaksis(): HasOne
    {
        return $this->hasOne(Transaksi::class, 'id', 'transaksi_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_harga'];

    /**
     * Relasi ke DetailTransaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detailTransaksis(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }

    /**
     * Relasi ke Barang melalui DetailTransaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function barangs(): HasManyThrough
    {
        return $this->hasManyThrough(Barang::class, TransaksiDetail::class, 'transaksi_id', 'id', 'id', 'barang_id');
    }
}

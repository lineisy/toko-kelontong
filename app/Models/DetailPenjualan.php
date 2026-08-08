<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    //
    use HasUuids;

    protected $table = 'detail_penjualans';
    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'jumlah',
        'harga',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}

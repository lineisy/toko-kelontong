<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Produk extends Model
{
    use HasUuids;

    protected $table = 'produks';
    protected $fillable = [
        'kategori_id',
        'code',
        'name',
        'harga'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    public function stok()
    {
        return $this->hasMany(Stok::class);
    }

}

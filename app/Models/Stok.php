<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Stok extends Model
{
    //
    use HasUuids;

    protected $table = 'stoks';
    protected $fillable = [
        'produk_id',
        'type',
        'jumlah',
        'harga_modal',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}

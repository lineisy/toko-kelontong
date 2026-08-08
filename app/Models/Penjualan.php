<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Penjualan extends Model
{
    use HasUuids;

    protected $table = 'penjualans';
    protected $fillable = [
        'user_id',
        'total',
        'bayar',
        'kembalian',
        'tanggal',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}

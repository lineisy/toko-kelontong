<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kategoris';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
    ];
}
<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Motor extends Model
{
    protected $collection = 'motor';

    protected $fillable = [
        'tahun_keluaran',
        'warna',
        'harga',
        'mesin',
        'tipe_suspensi',
        'tipe_transmisi',
    ];
}

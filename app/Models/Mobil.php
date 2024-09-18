<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Mobil extends Model
{
    protected $collection = 'mobil';

    protected $fillable = [
        'tahun_keluaran',
        'warna',
        'harga',
        'mesin',
        'kapasitas_penumpang',
        'tipe',
    ];
}

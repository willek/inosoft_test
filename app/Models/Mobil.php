<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

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

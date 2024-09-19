<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    const MOBIL = 'mobil';
    const MOTOR = 'motor';

    protected $collection = 'kendaraan';

    protected $fillable = [
        'jenis',
        'tahun_keluaran',
        'warna',
        'harga',
        'mesin',
    ];
}

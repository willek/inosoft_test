<?php

namespace App\Models;

use App\Repositories\StockRepo;
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

    protected $appends = [
        'stock'
    ];

    protected function getStockAttribute()
    {
        return StockRepo::getStock($this->_id);
    }
}

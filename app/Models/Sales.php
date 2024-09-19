<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Sales extends Model
{
    protected $collection = 'sales';

    protected $fillable = [
        'kendaraan_id',
        'harga',
        'qty',
        'total'
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id', '_id');
    }
}

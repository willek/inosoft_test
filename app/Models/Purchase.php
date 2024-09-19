<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Purchase extends Model
{
    protected $collection = 'purchase';

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

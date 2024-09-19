<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class StockCard extends Model
{
    protected $collection = 'stock_cards';

    protected $fillable = [
        'kendaraan_id',
        'qty'
    ];

}

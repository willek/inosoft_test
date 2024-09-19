<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mobil extends Kendaraan
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable([
            'kapasitas_penumpang',
            'tipe',
        ]);
    }
}

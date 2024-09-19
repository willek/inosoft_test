<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Motor extends Kendaraan
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable([
            'tipe_suspensi',
            'tipe_transmisi',
        ]);
    }
}

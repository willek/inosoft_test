<?php

namespace App\Repositories;

use App\Models\Mobil;

class MobilRepo extends KendaraanRepo
{
    protected $obj;

    public function __construct()
    {
        $this->obj = new Mobil();
    }
}
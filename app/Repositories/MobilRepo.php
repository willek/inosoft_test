<?php

declare(strict_types=1);

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
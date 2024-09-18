<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Motor;

class MotorRepo extends KendaraanRepo
{
    protected $obj;

    public function __construct()
    {
        $this->obj = new Motor;
    }
}
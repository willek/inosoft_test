<?php

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
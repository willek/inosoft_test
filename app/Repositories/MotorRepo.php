<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Kendaraan;
use App\Models\Motor;

class MotorRepo extends KendaraanRepo
{
    public function store(array $request): object
    {
        $data = new Motor;
        $data = $data->fill($request);
        $data->jenis = Kendaraan::MOTOR;
        $data->save();

        return $data;
    }
}
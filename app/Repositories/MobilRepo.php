<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Kendaraan;
use App\Models\Mobil;

class MobilRepo extends KendaraanRepo
{
    public function store(array $request): object
    {
        $data = new Mobil;
        $data->fill($request);
        $data->jenis = Kendaraan::MOBIL;

        $data->save();

        return $data;
    }
}
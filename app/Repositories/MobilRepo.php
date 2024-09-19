<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Kendaraan as Model;
use App\Models\Mobil;

class MobilRepo extends Kendaraan
{
    public function store(array $request): object
    {
        $data = new Mobil;
        $data->fill($request);
        $data->jenis = Model::MOBIL;
        $data->save();

        return $data;
    }

    public function update(array $request, string $id): object
    {
        $data = Mobil::findOrFail($id);
        $data->update($request);

        return $data;
    }
}
<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Kendaraan as Model;

abstract class Kendaraan implements KendaraanInterface
{
    public function all($type = null): object
    {
        $data = Model::when($type != null, function($q) use ($type) {
            return $q->where('jenis', $type);
        })->get();

        return $data;
    }

    public function find(string $id): object
    {
        $data = Model::findOrFail($id);

        return $data;
    }

    abstract function store(array $request): object;

    public function update(object $obj, array $request): object
    {
        $obj->update($request);

        return $obj;
    }

    public function delete(object $obj): bool
    {
        $data = $obj->delete();

        return $data;
    }
}
<?php

declare(strict_types=1);

namespace App\Repositories;

class KendaraanRepo implements KendaraanRepoInterface
{
    public function all() :object
    {
        $data = $this->obj->get();

        return $data;
    }

    public function find(string $id) :object
    {
        $data = $this->obj->findOrFail($id);

        return $data;
    }

    public function store(array $request) :object
    {
        $data = $this->obj->fill($request);

        $data->save();

        return $data;
    }

    public function update(object $obj, array $request) :bool
    {
        $data = $obj->update($request);

        return $data;
    }

    public function delete(object $obj) :bool
    {
        $data = $obj->delete();

        return $data;
    }
}
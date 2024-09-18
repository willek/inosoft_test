<?php

declare(strict_types=1);

namespace App\Repositories;

class KendaraanRepo implements KendaraanRepoInterface
{
    public function all() {
        $data = $this->obj->get();

        return $data;
    }

    public function find(string $id) {
        $data = $this->obj->findOrFail($id);

        return $data;
    }

    public function store(array $request) {
        $data = $this->obj->fill($request);

        $data->save();

        return $data;
    }

    public function update($obj, $request) {
        $data = $obj->update($request);

        return $data;
    }

    public function delete($obj) {
        $obj->delete();
    }
}
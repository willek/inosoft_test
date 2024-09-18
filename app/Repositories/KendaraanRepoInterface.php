<?php

namespace App\Repositories;

interface KendaraanRepoInterface
{
    public function all();
    public function find(string $id);
    public function store(array $data);
    public function update($obj, $request);
    public function delete($obj);
}
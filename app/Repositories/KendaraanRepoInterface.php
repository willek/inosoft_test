<?php

namespace App\Repositories;

interface KendaraanRepoInterface
{
    public function all() :object;
    public function find(string $id) :object;
    public function store(array $request) :object;
    public function update(object $obj, array $request) :bool;
    public function delete(object $obj) :bool;
}
<?php

namespace App\Repositories;

interface KendaraanInterface
{
    public function all($type): object;
    public function find(string $id): object;
    public function store(array $request): object;
    public function update(object $obj, array $request): object;
    public function delete(object $obj): bool;
}
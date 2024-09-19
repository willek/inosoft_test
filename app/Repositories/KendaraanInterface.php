<?php

declare(strict_types=1);

namespace App\Repositories;

interface KendaraanInterface
{
    public function all(string $type): object;
    public function find(string $id): object;
    public function store(array $request): object;
    public function update(array $request, string $id): object;
    public function delete(object $obj): bool;
}
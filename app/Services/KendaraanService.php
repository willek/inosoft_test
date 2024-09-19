<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\KendaraanRepo;

class KendaraanService
{
    public function __construct(
        protected KendaraanRepo $kendaraanRepo
    ) {}

    public function all(): object
    {
        return $this->kendaraanRepo->all();
    }

    public function find(string $id): object
    {
        return $this->kendaraanRepo->find($id);
    }
}
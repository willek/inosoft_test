<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\MobilCreateRequest;
use App\Http\Requests\MobilUpdateRequest;
use App\Models\Kendaraan;
use App\Repositories\MobilRepo;

class MobilService
{
    public function __construct(
        protected MobilRepo $mobilRepo
    ) {}

    public function all(): object
    {
        return $this->mobilRepo->all(Kendaraan::MOBIL);
    }

    public function find(string $id): object
    {
        return $this->mobilRepo->find($id);
    }

    public function store(MobilCreateRequest $request): object
    {
        $validated = $request->validated();

        return $this->mobilRepo->store($validated);
    }

    public function update(MobilUpdateRequest $request, string $id): object
    {
        $validated = $request->validated();

        return $this->mobilRepo->update($validated, $id);
    }

    public function delete(string $id): bool
    {
        $obj = $this->find($id);

        return $this->mobilRepo->delete($obj);
    }
}
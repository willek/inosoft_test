<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\MotorCreateRequest;
use App\Http\Requests\MotorUpdateRequest;
use App\Models\Kendaraan;
use App\Repositories\MotorRepo;

class MotorService
{
    public function __construct(
        protected MotorRepo $motorRepo
    ) {}

    public function all(): object
    {
        return $this->motorRepo->all(Kendaraan::MOTOR);
    }

    public function find(string $id): object
    {
        return $this->motorRepo->find($id);
    }

    public function store(MotorCreateRequest $request): object
    {
        $validated = $request->validated();

        return $this->motorRepo->store($validated);
    }

    public function update(MotorUpdateRequest $request, string $id): object
    {
        $validated = $request->validated();

        return $this->motorRepo->update($validated, $id);
    }

    public function delete(string $id): bool
    {
        $obj = $this->find($id);

        return $this->motorRepo->delete($obj);
    }
}
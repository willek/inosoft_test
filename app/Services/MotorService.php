<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\MotorCreateRequest;
use App\Http\Requests\MotorUpdateRequest;
use App\Repositories\MotorRepo;

class MotorService
{
    protected $motorRepo;

    public function __construct()
    {
        $this->motorRepo = new MotorRepo;
    }

    public function all() :object
    {
        return $this->motorRepo->all();
    }

    public function find(string $id) :object
    {
        return $this->motorRepo->find($id);
    }

    public function store(MotorCreateRequest $request) :object
    {
        $validated = $request->validated();

        return $this->motorRepo->store($validated);
    }

    public function update(MotorUpdateRequest $request, string $id) :bool
    {
        $validated = $request->validated();
        $obj = $this->find($id);

        return $this->motorRepo->update($obj, $validated);
    }

    public function delete(string $id) :bool
    {
        $obj = $this->find($id);

        return $this->motorRepo->delete($obj);
    }
}
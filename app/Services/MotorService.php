<?php

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

    public function all()
    {
        return $this->motorRepo->all();
    }

    public function find($id)
    {
        return $this->motorRepo->find($id);
    }

    public function store(MotorCreateRequest $request)
    {
        $validated = $request->validated();

        return $this->motorRepo->store($validated);
    }

    public function update(MotorUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $obj = $this->find($id);

        return $this->motorRepo->update($obj, $validated);
    }

    public function delete($id)
    {
        $obj = $this->find($id);

        return $this->motorRepo->delete($obj);
    }
}
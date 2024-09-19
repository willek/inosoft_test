<?php

namespace App\Http\Controllers;

use App\Http\Requests\MotorCreateRequest;
use App\Http\Requests\MotorUpdateRequest;
use App\Services\MotorService;

class MotorController extends Controller
{
    public function __construct(
        protected MotorService $motorService
    ) {}

    public function index()
    {
        $data = $this->motorService->all();

        return response()->ok($data);
    }

    public function show(string $id)
    {
        $data = $this->motorService->find($id);

        return response()->ok($data);
    }

    public function store(MotorCreateRequest $request)
    {
        $this->motorService->store($request);

        return response()->created();
    }

    public function update(MotorUpdateRequest $request, string $id)
    {
        $this->motorService->update($request, $id);

        return response()->ok();
    }

    public function destroy(string $id)
    {
        $this->motorService->delete($id);

        return response()->ok();
    }
}

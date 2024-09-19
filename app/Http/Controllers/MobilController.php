<?php

namespace App\Http\Controllers;

use App\Http\Requests\MobilCreateRequest;
use App\Http\Requests\MobilUpdateRequest;
use App\Services\MobilService;

class MobilController extends Controller
{
    public function __construct(
        protected MobilService $mobilService
    ) {}

    public function index()
    {
        $data = $this->mobilService->all();

        return response()->ok($data);
    }

    public function show(string $id)
    {
        $data = $this->mobilService->find($id);

        return response()->ok($data);
    }

    public function store(MobilCreateRequest $request)
    {
        $data = $this->mobilService->store($request);

        return response()->created($data);
    }

    public function update(MobilUpdateRequest $request, string $id)
    {
        $data = $this->mobilService->update($request, $id);

        return response()->ok($data);
    }

    public function destroy(string $id)
    {
        $this->mobilService->delete($id);

        return response()->ok();
    }
}

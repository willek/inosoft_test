<?php

namespace App\Http\Controllers;

use App\Http\Requests\MobilCreateRequest;
use App\Http\Requests\MobilUpdateRequest;
use App\Services\MobilService;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    private $mobilService;

    public function __construct()
    {
        $this->mobilService = new MobilService;
    }

    public function index()
    {
        $data = $this->mobilService->all();

        return response()->ok($data);
    }

    public function show($id)
    {
        $data = $this->mobilService->find($id);

        return response()->ok($data);
    }

    public function store(MobilCreateRequest $request)
    {
        $this->mobilService->store($request);

        return response()->created();
    }

    public function update(MobilUpdateRequest $request, $id)
    {
        $this->mobilService->update($request, $id);

        return response()->ok();
    }

    public function destroy($id)
    {
        $this->mobilService->delete($id);

        return response()->ok();
    }
}

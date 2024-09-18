<?php

namespace App\Services;

use App\Http\Requests\MobilCreateRequest;
use App\Http\Requests\MobilUpdateRequest;
use App\Repositories\MobilRepo;

class MobilService
{
    protected $mobilRepo;

    public function __construct()
    {
        $this->mobilRepo = new MobilRepo;
    }

    public function all()
    {
        return $this->mobilRepo->all();
    }

    public function find($id)
    {
        return $this->mobilRepo->find($id);
    }

    public function store(MobilCreateRequest $request)
    {
        $validated = $request->validated();

        return $this->mobilRepo->store($validated);
    }

    public function update(MobilUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $obj = $this->find($id);

        return $this->mobilRepo->update($obj, $validated);
    }

    public function delete($id)
    {
        $obj = $this->find($id);

        return $this->mobilRepo->delete($obj);
    }
}
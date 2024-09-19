<?php

namespace App\Http\Controllers;

use App\Services\KendaraanService;

class KendaraanController extends Controller
{
    public function __construct(
        protected KendaraanService $kendaraanService
    ) {}

    public function index()
    {
        $data = $this->kendaraanService->all();

        return response()->ok($data);
    }
}

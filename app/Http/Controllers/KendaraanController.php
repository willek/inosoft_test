<?php

namespace App\Http\Controllers;

use App\Services\KendaraanService;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function __construct(
        protected KendaraanService $kendaraanService
    ) {}

    public function index($kendaraan_id = null)
    {
        if ($kendaraan_id) {
            $data = $this->kendaraanService->find($kendaraan_id);
        } else {
            $data = $this->kendaraanService->all();
        }

        return response()->ok($data);
    }

    public function beli(Request $request)
    {
        $validate = $request->validate([
            'kendaraan_id' => 'required',
            'qty' => 'required|numeric|gt:0'
        ]);

        $data = $this->kendaraanService->beli($validate['kendaraan_id'], $validate['qty']);

        return response()->ok($data);
    }

    public function jual(Request $request)
    {
        $validate = $request->validate([
            'kendaraan_id' => 'required',
            'qty' => 'required|numeric|gt:0'
        ]);

        $data = $this->kendaraanService->jual($validate['kendaraan_id'], $validate['qty']);

        return response()->ok($data);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\KendaraanService;
use Illuminate\Http\Request;

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

    public function stock(Request $request)
    {
        $validate = $request->validate([
            'kendaraan_id' => 'required',
        ]);

        $data['kendaraan'] = $this->kendaraanService->find($validate['kendaraan_id']);
        $data['stock'] = $this->kendaraanService->stock($validate['kendaraan_id']);

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

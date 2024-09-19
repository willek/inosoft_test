<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Sales;

class SalesRepo
{
    public function create(string $kendaraan_id, int $qty, float $harga): object
    {
        $data = new Sales;
        $data->fill([
            'kendaraan_id' => $kendaraan_id,
            'harga' => $harga,
            'qty' => $qty,
            'total' => $qty * $harga
        ]);
        
        $data->save();

        return $data;
    }

    public function report(string $kendaran_id = null): object
    {
        $data = Sales::when($kendaran_id, function ($q) use ($kendaran_id) {
            return $q->where('kendaraan_id', $kendaran_id);
        })
        ->with('kendaraan:tahun_keluaran,warna,harga,mesin,kapasitas_penumpang,tipe')
        ->select('_id', 'kendaraan_id', 'harga', 'qty', 'total')
        ->get();

        return $data;
    }
}
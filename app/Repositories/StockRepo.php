<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\StockCard;

class StockRepo
{
    public function addEntry($kendaraan_id, $qty): object
    {
        $data = new StockCard;
        $data = $data->fill([
            'kendaraan_id' => $kendaraan_id,
            'qty' => $qty,
        ]);
        $data->save();

        return $data;
    }

    public function getStock($kendaraan_id)
    {
        $data = StockCard::where('kendaraan_id', $kendaraan_id)->get();

        return $data->sum('qty');
    }
}
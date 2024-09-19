<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\StockCard;

class StockRepo
{
    public function addEntry(string $kendaraan_id, int $qty): object
    {
        $data = new StockCard;
        $data = $data->fill([
            'kendaraan_id' => $kendaraan_id,
            'qty' => $qty,
        ]);
        $data->save();

        return $data;
    }

    public static function getStock(string $kendaraan_id): int
    {
        $data = StockCard::where('kendaraan_id', $kendaraan_id)->get();

        return $data->sum('qty');
    }
}
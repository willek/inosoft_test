<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\KendaraanRepo;
use App\Repositories\StockRepo;

class KendaraanService
{
    public function __construct(
        protected KendaraanRepo $kendaraanRepo,
        protected StockRepo $stockRepo
    ) {}

    public function all(): object
    {
        return $this->kendaraanRepo->all();
    }

    public function find(string $id): object
    {
        return $this->kendaraanRepo->find($id);
    }

    public function stock($kendaraan_id): int
    {
        $kendaraan = $this->find($kendaraan_id);

        return $this->stockRepo->getStock($kendaraan->_id);
    }

    public function beli($kendaraan_id, $qty): object
    {
        $kendaraan = $this->find($kendaraan_id);

        $this->stockRepo->addEntry($kendaraan->_id, $qty);

        return $this->res(true);
    }

    public function jual($kendaraan_id, $qty): object
    {
        $kendaraan = $this->find($kendaraan_id);

        $stock = $this->stock($kendaraan->_id);

        if ($stock <= 0) {
            return $this->res(false, 'stock kosong');
        }

        if ($stock - $qty < 0) {
            return $this->res(false, 'stock kurang');
        }

        $qty = (-1 * $qty); //convert to minus

        $this->stockRepo->addEntry($kendaraan->_id, $qty);

        return $this->res(true);
    }

    private function res(bool $success, string $message = null): object
    {
        $res = [
            'success' => $success
        ];

        if ($message) {
            $res['message'] = $message;
        }

        return (object) $res;
    }
}
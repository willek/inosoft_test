<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\KendaraanRepo;
use App\Repositories\PurchaseRepo;
use App\Repositories\SalesRepo;
use App\Repositories\StockRepo;

class KendaraanService
{
    public function __construct(
        protected KendaraanRepo $kendaraanRepo,
        protected PurchaseRepo $purchaseRepo,
        protected SalesRepo $salesRepo,
        protected StockRepo $stockRepo,
    ) {}

    public function all(): object
    {
        return $this->kendaraanRepo->all();
    }

    public function find(string $id): object
    {
        return $this->kendaraanRepo->find($id);
    }

    public function beli(string $kendaraan_id, int $qty): object
    {
        $kendaraan = $this->find($kendaraan_id);

        // add entry
        $this->stockRepo->addEntry($kendaraan->_id, $qty);

        // add sales data
        $this->purchaseRepo->create(
            kendaraan_id: $kendaraan->_id,
            harga: (float) $kendaraan->harga,
            qty: $qty,
        );

        return $this->res(true);
    }

    public function jual(string $kendaraan_id, int $qty): object
    {
        $kendaraan = $this->find($kendaraan_id);

        $stock = $this->stockRepo->getStock($kendaraan->_id);

        if ($stock <= 0) {
            return $this->res(false, 'stock kosong');
        }

        if ($stock - $qty < 0) {
            return $this->res(false, 'stock kurang');
        }

        // add entry with minus qty
        $this->stockRepo->addEntry($kendaraan->_id, (-1 * $qty));

        // add sales data
        $this->salesRepo->create(
            kendaraan_id: $kendaraan->_id,
            harga: (float) $kendaraan->harga,
            qty: $qty,
        );

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
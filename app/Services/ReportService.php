<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\PurchaseRepo;
use App\Repositories\SalesRepo;

class ReportService
{
    public function __construct(
        protected SalesRepo $salesRepo,
        protected PurchaseRepo $purchaseRepo
    ) {}

    public function salesReport(string $kendaraan_id = null): object
    {
        return $this->salesRepo->report($kendaraan_id);
    }

    public function purchaseReport(string $kendaraan_id = null): object
    {
        return $this->purchaseRepo->report($kendaraan_id);
    }

    public function sales(string $kendaraan_id = null): ?object
    {
        $sales = $this->salesReport($kendaraan_id);
        
        if (!count((array) $sales)) {
            return null;
        }

        $total_amount = 0;
        $total_qty = 0;

        foreach($sales as $v) {
            $v = (object) $v;
            $total_amount += $v->total;
            $total_qty += $v->qty;
        }

        return (object) [
            'total_amount' => $total_amount,
            'total_qty' => $total_qty,
        ];
    }

    public function purchase(string $kendaraan_id = null): ?object
    {
        $purchase = $this->purchaseReport($kendaraan_id);
        
        if (!count((array) $purchase)) {
            return null;
        }

        $total_amount = 0;
        $total_qty = 0;

        foreach($purchase as $v) {
            $v = (object) $v;
            $total_amount += $v->total;
            $total_qty += $v->qty;
        }

        return (object) [
            'total_amount' => $total_amount,
            'total_qty' => $total_qty,
        ];
    }
}
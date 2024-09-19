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
        
        if (!count($sales)) {
            return null;
        }

        return (object) [
            'total_amount' => $sales->sum('total'),
            'total_qty' => $sales->sum('qty'),
        ];
    }

    public function purchase(string $kendaraan_id = null): ?object
    {
        $purchase = $this->purchaseReport($kendaraan_id);
        
        if (!count($purchase)) {
            return null;
        }

        return (object) [
            'total_amount' => $purchase->sum('total'),
            'total_qty' => $purchase->sum('qty'),
        ];
    }
}
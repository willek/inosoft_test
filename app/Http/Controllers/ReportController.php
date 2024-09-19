<?php

namespace App\Http\Controllers;

use App\Services\ReportService;

class ReportController extends Controller
{
    public function __construct (
        protected ReportService $reportService
    ) {}

    public function sales($kendaraan_id = null)
    {
        $data['sales'] = $this->reportService->sales($kendaraan_id);
        $data['sales_detail'] = $this->reportService->salesReport($kendaraan_id);

        return response()->ok($data);
    }

    public function purchase($kendaraan_id = null)
    {
        $data['purchase'] = $this->reportService->purchase($kendaraan_id);
        $data['purchase_detail'] = $this->reportService->purchaseReport($kendaraan_id);

        return response()->ok($data);
    }
}

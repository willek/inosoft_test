<?php

namespace Tests\Feature;

use App\Repositories\PurchaseRepo;
use App\Repositories\SalesRepo;
use App\Services\ReportService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;
use Tests\TestCase;

class ReportServiceTest extends TestCase
{
    use WithoutMiddleware;

    protected SalesRepo $salesRepo;
    protected PurchaseRepo $purchaseRepo;
    protected ReportService $reportService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->salesRepo = Mockery::mock(SalesRepo::class);
        $this->purchaseRepo = Mockery::mock(PurchaseRepo::class);
        $this->reportService = new ReportService($this->salesRepo, $this->purchaseRepo);
    }

    public function testSalesReport(): void
    {
        $kendaraanId = '123';
        $salesData = (object) [
            ['total' => 100, 'qty' => 2],
            ['total' => 200, 'qty' => 3],
        ];

        $this->salesRepo->shouldReceive('report')
            ->with($kendaraanId)
            ->andReturn($salesData);

        $result = $this->reportService->salesReport($kendaraanId);

        $this->assertEquals($salesData, $result);
    }

    public function testPurchaseReport(): void
    {
        $kendaraanId = '456';
        $purchaseData = (object) [
            ['total' => 300, 'qty' => 4],
            ['total' => 400, 'qty' => 5],
        ];

        $this->purchaseRepo->shouldReceive('report')
            ->with($kendaraanId)
            ->andReturn($purchaseData);

        $result = $this->reportService->purchaseReport($kendaraanId);

        $this->assertEquals($purchaseData, $result);
    }

    public function testSalesEmpty(): void
    {
        $kendaraanId = '123';
        $salesData = (object) [];

        $this->salesRepo->shouldReceive('report')
            ->with($kendaraanId)
            ->andReturn($salesData);

        $result = $this->reportService->sales($kendaraanId);

        $this->assertNull($result);
    }

    public function testPurchaseEmpty(): void
    {
        $kendaraanId = '456';
        $purchaseData = (object) [];

        $this->purchaseRepo->shouldReceive('report')
            ->with($kendaraanId)
            ->andReturn($purchaseData);

        $result = $this->reportService->purchase($kendaraanId);

        $this->assertNull($result);
    }
}
<?php

namespace Tests\Unit;

use App\Models\Mobil;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\StockCard;
use App\Repositories\KendaraanRepo;
use App\Repositories\PurchaseRepo;
use App\Repositories\SalesRepo;
use App\Repositories\StockRepo;
use App\Services\KendaraanService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;
use Tests\TestCase;

class KendaraanServiceTest extends TestCase
{
    use WithoutMiddleware;
    
    private $kendaraanService;
    private $kendaraanRepo;
    private $purchaseRepo;
    private $salesRepo;
    private $stockRepo;
    
    private $kendaraan;
    private static $harga = 10000;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->kendaraanRepo = new KendaraanRepo;
        $this->salesRepo = new SalesRepo;
        $this->purchaseRepo = new PurchaseRepo;
        $this->stockRepo = new StockRepo;
        $this->kendaraanService = new KendaraanService(
            $this->kendaraanRepo,
            $this->purchaseRepo,
            $this->salesRepo,
            $this->stockRepo
        );

        $this->kendaraan = Mobil::factory()->create([
            'harga' => self::$harga,
        ]);
    }

    public static function tearDownAfterClass(): void
    {
        (new self())->setUp();

        Mobil::truncate();
        StockCard::truncate();
        Sales::truncate();
        Purchase::truncate();
    }

    public function test_beli_success()
    {
        $qty = 2;

        $response = $this->kendaraanRepo->find($this->kendaraan->_id)->toArray();
        $this->assertEquals(self::$harga, $response['harga']);

        $response = $this->kendaraanService->beli($this->kendaraan->_id, $qty);
        $this->assertTrue($response->success);
    }

    public function test_beli_failed()
    {
        $qty = -10;

        $response = $this->kendaraanRepo->find($this->kendaraan->_id)->toArray();
        $this->assertEquals(self::$harga, $response['harga']);

        $response = $this->kendaraanService->beli($this->kendaraan->_id, $qty);
        $this->assertFalse($response->success);
    }

    public function test_jual_success()
    {
        $qty = 2;

        $response = $this->kendaraanRepo->find($this->kendaraan->_id)->toArray();
        $this->assertEquals(self::$harga, $response['harga']);

        // add stock to kendaraan
        $response = $this->stockRepo->addEntry($this->kendaraan->_id, $qty)->toArray();
        $this->assertEquals($this->kendaraan->_id, $response['kendaraan_id']);
        $this->assertEquals($qty, $response['qty']);

        $response = $this->kendaraanService->jual($this->kendaraan->_id, $qty);
        $this->assertTrue($response->success);
    }

    public function test_jual_failed()
    {
        $qty = 2;

        $response = $this->kendaraanRepo->find($this->kendaraan->_id)->toArray();
        $this->assertEquals(self::$harga, $response['harga']);

        // add stock to kendaraan
        $response = $this->stockRepo->addEntry($this->kendaraan->_id, $qty)->toArray();
        $this->assertEquals($this->kendaraan->_id, $response['kendaraan_id']);
        $this->assertEquals($qty, $response['qty']);

        $response = $this->kendaraanService->jual($this->kendaraan->_id, 100);
        $this->assertFalse($response->success);
    }
}
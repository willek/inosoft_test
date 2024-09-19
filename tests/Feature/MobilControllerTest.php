<?php

namespace Tests\Feature;

use App\Models\Mobil;
use App\Services\MobilService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;
use Tests\TestCase;

class MobilControllerTest extends TestCase
{
    use WithoutMiddleware;

    private $mobilService;

    private $mobil;

    public function setUp(): void
    {
        parent::setUp();

        $this->mobilService = $this->mock(MobilService::class);

        $this->mobil = Mobil::factory()->create();
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public static function tearDownAfterClass(): void
    {
        (new self())->setUp();

        Mobil::truncate();
    }

    public function test_get_all()
    {
        $mockData = (object) [
            ['id' => '1', 'tahun_keluaran' => '2000'],
            ['id' => '2', 'tahun_keluaran' => '1990'],
        ];

        $this->mobilService->shouldReceive('all')->once()->andReturn($mockData);

        $response = $this->getJson('api/mobil');

        $response->assertOk();

        $this->assertCount(2, $response->json('data'));

        foreach ($response->json('data') as $index => $mobil) {
            $this->assertEquals($mockData->$index['id'], $mobil['id']);
            $this->assertEquals($mockData->$index['tahun_keluaran'], $mobil['tahun_keluaran']);
        }
    }

    public function test_find()
    {
        $this->mobilService->shouldReceive('find')->once()->andReturn($this->mobil);

        $response = $this->getJson('api/mobil/' . $this->mobil->_id);

        $response->assertOk();

        $this->assertEquals($this->mobil->_id, $response->json('data._id'));
        $this->assertEquals($this->mobil->tahun_keluaran, $response->json('data.tahun_keluaran'));
        $this->assertEquals($this->mobil->warna, $response->json('data.warna'));
        $this->assertEquals($this->mobil->harga, $response->json('data.harga'));
        $this->assertEquals($this->mobil->mesin, $response->json('data.mesin'));
        $this->assertEquals($this->mobil->kapasitas_penumpang, $response->json('data.kapasitas_penumpang'));
        $this->assertEquals($this->mobil->tipe, $response->json('data.tipe'));
    }

    public function test_store()
    {
        $this->mobilService->shouldReceive('store')->once()->andReturn($this->mobil);

        $response = $this->postJson('api/mobil', [
            'tahun_keluaran' => $this->mobil->tahun_keluaran,
            'warna' => $this->mobil->warna,
            'harga' => $this->mobil->harga,
            'mesin' => $this->mobil->mesin,
            'kapasitas_penumpang' => $this->mobil->kapasitas_penumpang,
            'tipe' => $this->mobil->tipe,
        ]);

        $response->assertStatus(201);
    }

    public function test_update()
    {
        $this->mobilService->shouldReceive('update')->once()->andReturn($this->mobil);

        $response = $this->patchJson('api/mobil/' . $this->mobil->_id, [
            'harga' => 10000,
        ]);

        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $this->mobilService->shouldReceive('delete')->once()->andReturn(true);

        $response = $this->delete('api/mobil/' . $this->mobil->_id);

        $response->assertStatus(200);
    }
}

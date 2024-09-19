<?php

namespace Tests\Feature;

use App\Models\Mobil;
use App\Services\MobilService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;
use Tests\TestCase;

class MobilServiceTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    public $mobilService;

    public function setUp(): void
    {
        parent::setUp();

        $this->mobilService = $this->mock(MobilService::class);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public static function tearDownAfterClass(): void
    {
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
        $mobil = Mobil::factory()->create();

        $this->mobilService->shouldReceive('find')->once()->andReturn($mobil);

        $response = $this->getJson('api/mobil/' . $mobil->_id);

        $response->assertOk();

        $this->assertEquals($response->json('data._id'), $mobil->_id);
        $this->assertEquals($response->json('data.tahun_keluaran'), $mobil->tahun_keluaran);
        $this->assertEquals($response->json('data.warna'), $mobil->warna);
        $this->assertEquals($response->json('data.harga'), $mobil->harga);
        $this->assertEquals($response->json('data.mesin'), $mobil->mesin);
        $this->assertEquals($response->json('data.kapasitas_penumpang'), $mobil->kapasitas_penumpang);
        $this->assertEquals($response->json('data.tipe'), $mobil->tipe);
    }

    public function test_store()
    {
        $mobil = Mobil::factory()->create();

        $this->mobilService->shouldReceive('store')->once()->andReturn($mobil);

        $response = $this->postJson('api/mobil', [
            'tahun_keluaran' => $mobil->tahun_keluaran,
            'warna' => $mobil->warna,
            'harga' => $mobil->harga,
            'mesin' => $mobil->mesin,
            'kapasitas_penumpang' => $mobil->kapasitas_penumpang,
            'tipe' => $mobil->tipe,
        ]);

        $response->assertStatus(201);
    }

    public function test_update()
    {
        $mobil = Mobil::factory()->create();

        $this->mobilService->shouldReceive('update')->once()->andReturn(true);

        $response = $this->patchJson('api/mobil/' . $mobil->_id, [
            'harga' => 10000,
        ]);

        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $mobil = Mobil::factory()->create();

        $this->mobilService->shouldReceive('delete')->once()->andReturn(true);

        $response = $this->delete('api/mobil/' . $mobil->_id);

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Motor;
use App\Services\MotorService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;
use Tests\TestCase;

class MotorServiceTest extends TestCase
{
    use WithoutMiddleware;

    public $motorService;
    
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->motorService = $this->mock(MotorService::class);
    }

    public static function tearDownAfterClass(): void
    {
        Motor::truncate();
    }

    public function test_get_all()
    {
        $mockData = (object) [
            ['id' => '1', 'tahun_keluaran' => '2000'],
            ['id' => '2', 'tahun_keluaran' => '1990'],
        ];

        $this->motorService->shouldReceive('all')->once()->andReturn($mockData);

        $response = $this->getJson('api/motor');

        $response->assertOk();

        $this->assertCount(2, $response->json('data'));

        foreach ($response->json('data') as $index => $motor) {
            $this->assertEquals($mockData->$index['id'], $motor['id']);
            $this->assertEquals($mockData->$index['tahun_keluaran'], $motor['tahun_keluaran']);
        }
    }

    public function test_find()
    {
        $motor = Motor::factory()->create();

        $this->motorService->shouldReceive('find')->once()->andReturn($motor);

        $response = $this->getJson('api/motor/' . $motor->_id);

        $response->assertOk();

        $this->assertEquals($response->json('data._id'), $motor->_id);
        $this->assertEquals($response->json('data.tahun_keluaran'), $motor->tahun_keluaran);
        $this->assertEquals($response->json('data.warna'), $motor->warna);
        $this->assertEquals($response->json('data.harga'), $motor->harga);
        $this->assertEquals($response->json('data.mesin'), $motor->mesin);
        $this->assertEquals($response->json('data.tipe_suspensi'), $motor->tipe_suspensi);
        $this->assertEquals($response->json('data.tipe_transmisi'), $motor->tipe_transmisi);
    }

    public function test_store()
    {
        $motor = Motor::factory()->create();

        $this->motorService->shouldReceive('store')->once()->andReturn($motor);

        $response = $this->postJson('api/motor', [
            'tahun_keluaran' => $motor->tahun_keluaran,
            'warna' => $motor->warna,
            'harga' => $motor->harga,
            'mesin' => $motor->mesin,
            'tipe_suspensi' => $motor->tipe_suspensi,
            'tipe_transmisi' => $motor->tipe_transmisi,
        ]);

        $response->assertStatus(201);
    }

    public function test_update()
    {
        $motor = Motor::factory()->create();

        $this->motorService->shouldReceive('update')->once()->andReturn($motor);

        $response = $this->patchJson('api/motor/' . $motor->_id, [
            'harga' => 10000,
        ]);

        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $motor = Motor::factory()->create();

        $this->motorService->shouldReceive('delete')->once()->andReturn(true);

        $response = $this->delete('api/motor/' . $motor->_id);

        $response->assertStatus(200);
    }
}

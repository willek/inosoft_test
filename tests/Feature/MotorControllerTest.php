<?php

namespace Tests\Feature;

use App\Models\Motor;
use App\Services\MotorService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;
use Tests\TestCase;

class MotorControllerTest extends TestCase
{
    use WithoutMiddleware;

    private $motorService;

    private $motor;

    public function setUp(): void
    {
        parent::setUp();

        $this->motorService = $this->mock(MotorService::class);

        $this->motor = Motor::factory()->create();
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public static function tearDownAfterClass(): void
    {
        (new self())->setUp();

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
        $this->motorService->shouldReceive('find')->once()->andReturn($this->motor);

        $response = $this->getJson('api/motor/' . $this->motor->_id);

        $response->assertOk();

        $this->assertEquals($this->motor->_id, $response->json('data._id'));
        $this->assertEquals($this->motor->tahun_keluaran, $response->json('data.tahun_keluaran'));
        $this->assertEquals($this->motor->warna, $response->json('data.warna'));
        $this->assertEquals($this->motor->harga, $response->json('data.harga'));
        $this->assertEquals($this->motor->mesin, $response->json('data.mesin'));
        $this->assertEquals($this->motor->tipe_suspensi, $response->json('data.tipe_suspensi'));
        $this->assertEquals($this->motor->tipe_transmisi, $response->json('data.tipe_transmisi'));
    }

    public function test_store()
    {
        $this->motorService->shouldReceive('store')->once()->andReturn($this->motor);

        $response = $this->postJson('api/motor', [
            'tahun_keluaran' => $this->motor->tahun_keluaran,
            'warna' => $this->motor->warna,
            'harga' => $this->motor->harga,
            'mesin' => $this->motor->mesin,
            'tipe_suspensi' => $this->motor->tipe_suspensi,
            'tipe_transmisi' => $this->motor->tipe_transmisi,
        ]);

        $response->assertStatus(201);
    }

    public function test_update()
    {
        $this->motorService->shouldReceive('update')->once()->andReturn($this->motor);

        $response = $this->patchJson('api/motor/' . $this->motor->_id, [
            'harga' => 10000,
        ]);

        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $this->motorService->shouldReceive('delete')->once()->andReturn(true);

        $response = $this->delete('api/motor/' . $this->motor->_id);

        $response->assertStatus(200);
    }
}

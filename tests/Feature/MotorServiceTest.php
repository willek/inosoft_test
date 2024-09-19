<?php

namespace Tests\Feature;

use App\Http\Requests\MotorCreateRequest;
use App\Http\Requests\MotorUpdateRequest;
use App\Models\Motor;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Repositories\MotorRepo;
use App\Services\MotorService;
use Validator;
use Tests\TestCase;

class MotorServiceTest extends TestCase
{
    use WithoutMiddleware;

    private $motorRepo;
    private $motorService;

    private $motorData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->motorRepo = new MotorRepo;
        $this->motorService = new MotorService(
            $this->motorRepo,
        );

        $this->motorData = [
            'tahun_keluaran' => 1234,
            'warna' => 'silver',
            'harga' => 500,
            'mesin' => 'bagus',
            'tipe_suspensi' => 'mono',
            'tipe_transmisi' => 'A/T',
        ];
    }

    public static function tearDownAfterClass(): void
    {
        (new self())->setUp();

        Motor::truncate();
    }

    public function test_all_empty()
    {
        $response = $this->motorService->all();

        $this->assertEmpty($response);
    }

    public function test_all_not_empty()
    {
        Motor::factory(3)->create();

        $response = $this->motorService->all();

        $this->assertNotEmpty($response);
        $this->assertCount(3, $response);
    }

    public function test_find()
    {
        $motor = Motor::factory()->create();

        $response = $this->motorService->find($motor->_id);

        $this->assertEquals($motor->_id, $response->_id);
        $this->assertEquals($motor->jenis, $response->jenis);
        $this->assertEquals($motor->tahun_keluaran, $response->tahun_keluaran);
        $this->assertEquals($motor->warna, $response->warna);
        $this->assertEquals($motor->mesin, $response->mesin);
        $this->assertEquals($motor->tipe_suspensi, $response->tipe_suspensi);
        $this->assertEquals($motor->tipe_transmisi, $response->tipe_transmisi);
    }
    
    public function test_create()
    {
        $request = new MotorCreateRequest();
        $request->setMethod('POST');
        $request->request->add($this->motorData);
        $request->setValidator(
            Validator::make( 
                $request->all(),
                $request->rules(),
                $request->messages()
            )
        );

        $response = $this->motorService->store($request);

        $this->assertDataEquals($this->motorData, $response);

    }

    public function test_update()
    {
        $request = new MotorCreateRequest();
        $request->setMethod('POST');
        $request->request->add($this->motorData);
        $request->setValidator(
            Validator::make( 
                $request->all(),
                $request->rules(),
                $request->messages()
            )
        );

        $response = $this->motorService->store($request);

        $this->assertDataEquals($this->motorData, $response);

        $updateData = [
            'tipe_transmisi' => 'M/T'
        ];
        $request = new MotorUpdateRequest();
        $request->setMethod('PATCH');
        $request->request->add($updateData);
        $request->setValidator(
            Validator::make( 
                $request->all(),
                $request->rules(),
                $request->messages()
            )
        );

        $response = $this->motorService->update($request, $response->_id);

        $this->assertEquals($updateData['tipe_transmisi'], $response->tipe_transmisi);
    }

    public function test_delete()
    {
        $request = new MotorCreateRequest();
        $request->setMethod('POST');
        $request->request->add($this->motorData);
        $request->setValidator(
            Validator::make( 
                $request->all(),
                $request->rules(),
                $request->messages()
            )
        );

        $response = $this->motorService->store($request);

        $this->assertDataEquals($this->motorData, $response);

        $response = $this->motorService->delete($response->_id);

        $this->assertTrue($response);
    }

    private function assertDataEquals(array $expectedData, object $actual)
    {
        foreach ($expectedData as $key => $value) {
            $this->assertEquals($value, $actual->$key);
        }
    }
}

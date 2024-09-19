<?php

namespace Tests\Feature;

use App\Http\Requests\MobilCreateRequest;
use App\Http\Requests\MobilUpdateRequest;
use App\Models\Mobil;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Repositories\MobilRepo;
use App\Services\MobilService;
use Validator;
use Tests\TestCase;

class MobilServiceTest extends TestCase
{
    use WithoutMiddleware;

    private $mobilRepo;
    private $mobilService;

    private $mobilData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mobilRepo = new MobilRepo;
        $this->mobilService = new MobilService(
            $this->mobilRepo,
        );

        $this->mobilData = [
            'tahun_keluaran' => 1234,
            'warna' => 'silver',
            'harga' => 500,
            'mesin' => 'bagus',
            'kapasitas_penumpang' => '4',
            'tipe' => '5',
        ];
    }

    public static function tearDownAfterClass(): void
    {
        (new self())->setUp();

        Mobil::truncate();
    }

    public function test_all_empty()
    {
        $response = $this->mobilService->all();

        $this->assertEmpty($response);
    }

    public function test_all_not_empty()
    {
        Mobil::factory(3)->create();

        $response = $this->mobilService->all();

        $this->assertNotEmpty($response);
        $this->assertCount(3, $response);
    }

    public function test_find()
    {
        $mobil = Mobil::factory()->create();

        $response = $this->mobilService->find($mobil->_id);

        $this->assertEquals($mobil->_id, $response->_id);
        $this->assertEquals($mobil->jenis, $response->jenis);
        $this->assertEquals($mobil->tahun_keluaran, $response->tahun_keluaran);
        $this->assertEquals($mobil->warna, $response->warna);
        $this->assertEquals($mobil->mesin, $response->mesin);
        $this->assertEquals($mobil->kapasitas_penumpang, $response->kapasitas_penumpang);
        $this->assertEquals($mobil->tipe, $response->tipe);
    }
    
    public function test_create()
    {
        $request = new MobilCreateRequest();
        $request->setMethod('POST');
        $request->request->add($this->mobilData);
        $request->setValidator(
            Validator::make( 
                $request->all(),
                $request->rules(),
                $request->messages()
            )
        );

        $response = $this->mobilService->store($request);

        $this->assertDataEquals($this->mobilData, $response);

    }

    public function test_update()
    {
        $request = new MobilCreateRequest();
        $request->setMethod('POST');
        $request->request->add($this->mobilData);
        $request->setValidator(
            Validator::make( 
                $request->all(),
                $request->rules(),
                $request->messages()
            )
        );

        $response = $this->mobilService->store($request);

        $this->assertDataEquals($this->mobilData, $response);

        $updateData = [
            'tipe' => '2'
        ];
        $request = new MobilUpdateRequest();
        $request->setMethod('PATCH');
        $request->request->add($updateData);
        $request->setValidator(
            Validator::make( 
                $request->all(),
                $request->rules(),
                $request->messages()
            )
        );

        $response = $this->mobilService->update($request, $response->_id);

        $this->assertEquals($updateData['tipe'], $response->tipe);
    }

    public function test_delete()
    {
        $request = new MobilCreateRequest();
        $request->setMethod('POST');
        $request->request->add($this->mobilData);
        $request->setValidator(
            Validator::make( 
                $request->all(),
                $request->rules(),
                $request->messages()
            )
        );

        $response = $this->mobilService->store($request);

        $this->assertDataEquals($this->mobilData, $response);

        $response = $this->mobilService->delete($response->_id);

        $this->assertTrue($response);
    }

    private function assertDataEquals(array $expectedData, object $actual)
    {
        foreach ($expectedData as $key => $value) {
            $this->assertEquals($value, $actual->$key);
        }
    }
}

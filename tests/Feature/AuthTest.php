<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
  
    public function setUp() :void 
    {
        parent::setUp();
        
        $this->user = User::factory()->create([
            'password' => Hash::make(12345678)
        ]);
    }

    public function tearDown() :void
    {
        parent::tearDown();

        $this->user->delete();
    }

    public function test_login_failed()
    {
        // Login the user
        $response = $this->postJson('/api/auth/login', [
            'email' => 'random@mail.com',
            'password' => 12345678,
        ]);

        $response->assertUnauthorized();
    }

    public function test_login_returns_success_with_token()
    {
        // Login the user
        $response = $this->postJson('/api/auth/login', [
            'email' => $this->user->email,
            'password' => 12345678,
        ]);

        $response->assertOk();

        $this->assertNotEmpty($response->json('data.access_token'));
    }

    public function test_logout_successfully()
    {
        // Login the user
        $response = $this->postJson('/api/auth/login', [
            'email' => $this->user->email,
            'password' => 12345678,
        ]);

        $response->assertOk();

        $this->assertNotEmpty($response->json('data.access_token'));

        // Logout the user
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $response->json('data.access_token')
        ])->postJson('/api/auth/logout');

        $response->assertOk();
    }

    public function test_me_returns_correct_user_information()
    {
        // Login the user
        $response = $this->postJson('/api/auth/login', [
            'email' => $this->user->email,
            'password' => 12345678,
        ]);

        $response->assertOk();

        $this->assertNotEmpty($response->json('data.access_token'));

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $response->json('data.access_token')
        ])->postJson('/api/auth/me');

        $response->assertOk();

        $this->assertEquals($this->user->_id, $response->json('data._id'));
        $this->assertEquals($this->user->name, $response->json('data.name'));
        $this->assertEquals($this->user->email, $response->json('data.email'));
    }
}

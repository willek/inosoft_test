<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private $user;
    private static $password = '12345678';

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => Hash::make(self::$password)
        ]);
    }

    public static function tearDownAfterClass(): void
    {
        (new self())->setUp();

        User::truncate();
    }

    private function login(string $email, string $password)
    {
        return $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function test_login_failed()
    {
        // Login the user
        $response = $this->login('random@mail.com', self::$password);

        $response->assertUnauthorized();
    }

    public function test_login_returns_success_with_token()
    {
        // Login the user
        $response = $this->login($this->user->email, self::$password);

        $response->assertOk();

        $this->assertNotEmpty($response->json('data.access_token'));
    }

    public function test_logout_successfully()
    {
        // Login the user
        $response = $this->login($this->user->email, self::$password);

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
        $response = $this->login($this->user->email, self::$password);

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

    public function test_get_resource_with_login_return_success()
    {
        // Login the user
        $response = $this->login($this->user->email, self::$password);

        $response->assertOk();

        $this->assertNotEmpty($response->json('data.access_token'));

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $response->json('data.access_token')
        ])->getJson('/api/kendaraan');

        $response->assertOk();
    }

    public function test_get_resource_without_login_return_unauthorized()
    {
        $response = $this->getJson('/api/kendaraan');

        $response->assertUnauthorized();
    }
}

<?php

namespace Tests\Unit;

use App\Http\Controllers\AuthController;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login()
    {
        $this->withoutExceptionHandling();
        User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $payload = [
            'email' => 'admin@jextecnologies.com',
            'password' => '123456'
        ];
        $response = $this->postJson('api/v1/login', $payload);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [],
                'token',
            ]);
    }

    public function test_login_invalid_credentials()
    {
        $this->withoutExceptionHandling();
        User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $payload = [
            'email' => 'admin1@jextecnologies.com',
            'password' => '123456'
        ];
        $response = $this->postJson('api/v1/login', $payload);
        $response
            ->assertStatus(401)
            ->assertExactJson([
                'message' => 'Invalid Credentials.',
            ]);
    }

    public function test_logout()
    {
//        $this->withoutExceptionHandling();
        User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $payload = new LoginRequest();
        $payload->merge([
            'email' => 'admin@jextecnologies.com',
            'password' => '123456'
        ]);
        $response = app(AuthController::class)->login($payload);
        $token = $response->additional["token"];

        $response = $this->withHeaders([
            'Authorization' => "Bearer " . $token,
        ])->postJson('api/v1/logout');
        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'Token removed.',
            ]);
    }

    public function test_logout_unauthenticated()
    {
//        $this->withoutExceptionHandling();
        User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $payload = new LoginRequest();
        $payload->merge([
            'email' => 'admin1@jextecnologies.com',
            'password' => '123456'
        ]);
        $response = app(AuthController::class)->login($payload);
        $token = '';

        $response = $this->withHeaders([
            'Authorization' => "Bearer " . $token,
        ])->postJson('api/v1/logout');
        $response
            ->assertStatus(401)
            ->assertExactJson([
                'message' => 'Unauthenticated.',
            ]);
    }
}

<?php

namespace Tests\Unit;

use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private $resource = 'users';

    public function test_index()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        DocumentType::factory()->create(['name' => 'DNI']);
        Position::factory()->create(['name' => 'System Engineer']);
        Employee::factory()->create([
            'user_id' => $user
        ]);
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'email',
                    'employee' => [
                        'id',
                    ],
                ]
            ]]);

    }
}

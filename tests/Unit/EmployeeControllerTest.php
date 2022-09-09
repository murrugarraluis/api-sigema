<?php

namespace Tests\Unit;

use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Machine;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    private $resource = 'employees';

    public function seedData()
    {
        Position::factory()->create(['name' => 'System Engineer']);
        DocumentType::factory()->create(['name' => 'DNI']);
        Employee::factory(10)->create();
    }

    public function test_index()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $this->seedData();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'document_number',
                    'name',
                    'lastname',
                    'personal_email',
                    'phone',
                    'address',
                    'user',
                    'position' => [
                        'name'
                    ],
                    'document_type' => [
                        'name'
                    ],
                ]
            ]]);

    }
}

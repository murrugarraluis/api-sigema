<?php

namespace Tests\Unit;

use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Machine;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpParser\Comment\Doc;
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
                    'position' => [
                        'name'
                    ],
                    'document_type' => [
                        'name'
                    ],
                ]
            ]]);

    }

    public function test_show()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $this->seedData();
        $employee = Employee::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource/$employee->id");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                'id',
                'document_number',
                'name',
                'lastname',
                'personal_email',
                'phone',
                'address',
                'position' => [
                    'name'
                ],
                'document_type' => [
                    'name'
                ],
            ]]);

    }

    public function test_show_not_found()
    {
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource/1");

        $response->assertStatus(404)
            ->assertExactJson(['message' => "Unable to locate the employee you requested."]);
    }

    public function test_store()
    {

//        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $this->seedData();
        $payload = [
            'document_number' => '12345678',
            'name' => 'Luis',
            'lastname' => 'Rodriguez',
            'personal_email' => 'example@email.com',
            'phone' => '987654321',
            'address' => 'Av.Larco',
            'position' => [
                'id' => Position::limit(1)->first()->id,
            ],
            'document_type' => [
                'id' => DocumentType::limit(1)->first()->id,
            ],
        ];
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->postJson("api/v1/$this->resource", $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'document_number',
                    'name',
                    'lastname',
                    'personal_email',
                    'phone',
                    'address',
                    'position' => [
                        'name'
                    ],
                    'document_type' => [
                        'name'
                    ],
                ],
            ])->assertJson([
                'message' => 'Employee created.',
                'data' => []
            ]);

    }

    public function test_update()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $this->seedData();
        $employee = Employee::limit(1)->first();
        $payload = [
            'document_number' => '12345678',
            'name' => 'Luis',
            'lastname' => 'Rodriguez',
            'personal_email' => 'example@email.com',
            'phone' => '987654321',
            'address' => 'Av.Larco',
            'position' => [
                'id' => Position::limit(1)->first()->id,
            ],
            'document_type' => [
                'id' => DocumentType::limit(1)->first()->id,
            ],
        ];
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->putJson("api/v1/$this->resource/$employee->id", $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'document_number',
                    'name',
                    'lastname',
                    'personal_email',
                    'phone',
                    'address',
                    'position' => [
                        'name'
                    ],
                    'document_type' => [
                        'name'
                    ],
                ],
            ])->assertJson([
                'message' => 'Employee updated.',
                'data' => []
            ]);

    }

    public function test_generate_safe_credentials()
    {

//        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $this->seedData();
        $employee = Employee::factory()->create(['user_id' => null]);
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->postJson("api/v1/$this->resource/$employee->id/generate-safe-credentials");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'email',
                    'password',
                ],
            ])->assertJson([
                'message' => 'Safe credentials generated.',
                'data' => []
            ]);

    }

    public function test_destroy()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $this->seedData();
        $employee = Employee::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->deleteJson("api/v1/$this->resource/$employee->id");

        $response->assertStatus(200)
            ->assertExactJson(['message' => 'Employee removed.']);

    }
}

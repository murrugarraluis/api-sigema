<?php

namespace Tests\Unit;

use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Notification;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private $resource = 'users';

    public function seedData()
    {
        Notification::factory(2)->create();
        DocumentType::factory()->create(['name' => 'DNI']);
        Position::factory()->create(['name' => 'System Engineer']);
    }

    public function test_index()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $this->seedData();
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

    public function test_show()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $this->seedData();
        Employee::factory()->create([
            'user_id' => $user
        ]);
        $user = User::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource/$user->id");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                'id',
                'email',
                'employee' => [
                    'id',
                ],
            ]]);

    }

    public function test_show_notifications()
    {
        $this->withoutExceptionHandling();
        $this->seedData();
        $notifications = Notification::all();
        $user = User::factory()->hasAttached($notifications)->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        Employee::factory()->create([
            'user_id' => $user
        ]);
        $user = User::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource/$user->id/notifications");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
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
            ->assertExactJson(['message' => "Unable to locate the user you requested."]);
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
            'email' => 'example@email.com',
            'password' => '123456',
            'employee' => [
                'id' => (Employee::factory()->create(['user_id' => null]))->id
            ],
        ];
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->postJson("api/v1/$this->resource", $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'email',
                    'employee' => [
                        'id',
                    ],
                ],
            ])->assertJson([
                'message' => 'User created.',
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
        DocumentType::factory()->create(['name' => 'DNI']);
        Position::factory()->create(['name' => 'System Engineer']);
        Employee::factory()->create([
            'user_id' => $user
        ]);
        $user = User::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->deleteJson("api/v1/$this->resource/$user->id");

        $response->assertStatus(200)
            ->assertExactJson(['message' => 'User removed.']);

    }

}

<?php

namespace Tests\Unit;

use App\Models\Machine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MachineControllerTest extends TestCase
{
    use RefreshDatabase;

    private $resource = 'machines';

    public function seedData()
    {
        Machine::factory(5)->create();
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
                    'serie_number',
                    'name',
                    'brand',
                    'model',
                    'image',
                    'maximum_working_time',
                    'status',
                ]
            ]]);

    }
}

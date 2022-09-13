<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\ArticleType;
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
        ArticleType::factory()->create(['name' => 'Repuesto']);
        Article::factory(2)->create();
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

    public function test_show()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $this->seedData();
        $machine = Machine::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource/$machine->id");
        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                'id',
                'serie_number',
                'name',
                'brand',
                'model',
                'image',
                'maximum_working_time',
                'articles' => [
                    '*' => [
                        'id',
                        'name',
                    ]
                ],
                'status',
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
            ->assertExactJson(['message' => "Unable to locate the machine you requested."]);
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
            'serie_number' => '123456789',
            'name' => 'Machine',
            'brand' => 'brand',
            'model' => 'model',
            'image' => '',
            'maximum_working_time' => 300,
            'articles' => [
                [
                    'id' => Article::limit(1)->first()->id,
                ]
            ],
            'status' => '',
        ];
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->postJson("api/v1/$this->resource", $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'serie_number',
                    'name',
                    'brand',
                    'model',
                    'image',
                    'maximum_working_time',
                    'articles' => [
                        '*' => [
                            'id',
                            'name',
                        ]
                    ],
                    'status',
                ]
            ])->assertJson([
                'message' => 'Machine created.',
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
        $machine = Machine::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->putJson("api/v1/$this->resource/$machine->id");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'serie_number',
                    'name',
                    'brand',
                    'model',
                    'image',
                    'maximum_working_time',
                    'articles' => [
                        '*' => [
                            'id',
                            'name',
                        ]
                    ],
                    'status',
                ]
            ])->assertJson([
                'message' => 'Machine updated.',
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
        $machine = Machine::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->deleteJson("api/v1/$this->resource/$machine->id");
        $response->assertStatus(200)
            ->assertExactJson(['message' => 'Machine removed.']);

    }

}

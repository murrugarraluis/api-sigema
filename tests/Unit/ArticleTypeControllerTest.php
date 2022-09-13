<?php

namespace Tests\Unit;

use App\Models\ArticleType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTypeControllerTest extends TestCase
{
    use RefreshDatabase;

    private $resource = 'article-types';

    public function seedData()
    {
        ArticleType::factory()->create(['name' => 'article type']);
    }

    public function test_index()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => []]);

    }

    public function test_show()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $this->seedData();
        $article_type = ArticleType::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource/$article_type->id");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => []]);

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
            ->assertExactJson(['message' => "Unable to locate the article type you requested."]);
    }

    public function test_store()
    {

//        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $payload = [
            'name' => 'Article Type',
        ];
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->postJson("api/v1/$this->resource", $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ],
            ])->assertJson([
                'message' => 'Article Type created.',
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
        $article_type = ArticleType::limit(1)->first();
        $payload = [
            'name' => 'Article Type',
        ];
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->putJson("api/v1/$this->resource/$article_type->id", $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ],
            ])->assertJson([
                'message' => 'Article Type updated.',
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
        $article_type = ArticleType::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->deleteJson("api/v1/$this->resource/$article_type->id");

        $response->assertStatus(200)
            ->assertExactJson(['message' => 'Article Type removed.']);

    }
}

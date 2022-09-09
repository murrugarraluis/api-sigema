<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\ArticleType;
use App\Models\Machine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    private $resource = 'articles';
    public function seedData()
    {
        ArticleType::factory()->create(['name'=>'Oficina']);
        Article::factory(5)->create();
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
                    'name',
                    'brand',
                    'model',
                    'quantity',
                    'article_type' => [
                        'id',
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
        $article = Article::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource/$article->id");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                    'id',
                    'name',
                    'brand',
                    'model',
                    'quantity',
                    'article_type' => [
                        'id',
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
            ->assertExactJson(['message' => "Unable to locate the article you requested."]);
    }
}

<?php

namespace Tests\Unit;

use App\Models\Machine;
use App\Models\User;
use App\Models\WorkingSheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkingSheetControllerTest extends TestCase
{
    use RefreshDatabase;
    private $resource = 'working-sheets';
    public function seedData()
    {
        Machine::factory()->create();
        WorkingSheet::factory()->create();
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
                    'date_start',
                    'date_end',
                    'description',
                    'machine'=>[
                        'name'
                    ],
                ]
            ]]);

    }
    public function test_show()
    {
//        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);

        $this->seedData();
        $working_sheet = WorkingSheet::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource/$working_sheet->id");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                    'id',
                    'date_start',
                    'date_end',
                    'description',
                    'machine'=>[
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
            ->assertExactJson(['message' => "Unable to locate the working sheet you requested."]);
    }

}

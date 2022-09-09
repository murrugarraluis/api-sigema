<?php

namespace Tests\Unit;

use App\Models\AttendanceSheet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceSheetControllerTest extends TestCase
{
    use RefreshDatabase;
    private $resource = 'attendance-sheets';

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
        $attendance_sheet = AttendanceSheet::factory()->create();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource/$attendance_sheet->id");

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
            ->assertExactJson(['message' => "Unable to locate the attendance sheet you requested."]);
    }
}

<?php

namespace Tests\Unit;

use App\Models\AttendanceSheet;
use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceSheetControllerTest extends TestCase
{
    use RefreshDatabase;

    private $resource = 'attendance-sheets';

    public function seedData()
    {
        Position::factory()->create(['name'=>'System Engineer']);
        DocumentType::factory()->create(['name' => 'DNI']);
        $employees = Employee::factory(2)->create();
        AttendanceSheet::factory(5)
            ->hasAttached($employees,[
                "check_in"=>'10:00:00',
                "check_out"=>'15:00:00',
                "attendance"=>'asistencia',
            ])
            ->create();
    }

    public function test_index()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'email' => 'admin@jextecnologies.com',
            'password' => bcrypt('123456')
        ]);
        $this->seedData();
//        $attendance_sheet = AttendanceSheet::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                '*'=>[
                    'id',
                    'date',
                    'time_start',
                    'time_end',
                    'responsible',
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
        $attendance_sheet = AttendanceSheet::limit(1)->first();
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource/$attendance_sheet->id");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                'id',
                'date',
                'time_start',
                'time_end',
                'responsible',
                'employee'=>[
                    '*'=>[
                        'id',
                        'check_in',
                        'check_out',
                        'document_number',
                        'name',
                        'attendance_number',
                        'absences_number',
                        'attedance'
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
            ->assertExactJson(['message' => "Unable to locate the attendance sheet you requested."]);
    }
//    public function test_deleted()
//    {
//        $this->withoutExceptionHandling();
//        $user = User::factory()->create([
//            'email' => 'admin@jextecnologies.com',
//            'password' => bcrypt('123456')
//        ]);
//        $this->seedData();
//        $attendance_sheet = AttendanceSheet::limit(1)->first();
//        $response = $this->actingAs($user)->withSession(['banned' => false])
//            ->deleteJson("api/v1/$this->resource/$attendance_sheet->id");
//
//        $response->assertStatus(200)
//            ->assertExactJson(['message' => 'Attendance Sheet removed.']);
//
//    }
}

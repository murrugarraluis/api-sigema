<?php

namespace Tests\Unit;

use App\Models\DocumentType;
use App\Models\Machine;
use App\Models\MaintenanceSheet;
use App\Models\MaintenanceType;
use App\Models\Supplier;
use App\Models\SupplierType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceSheetControllerTest extends TestCase
{
    use RefreshDatabase;

    private $resource = 'maintenance-sheets';
    public function seedData()
    {
        MaintenanceType::factory()->create(['name'=>'Preventivo']);
        SupplierType::factory()->create(['name'=>'Servicio']);
        DocumentType::factory()->create(['name'=>'RUC']);
        Supplier::factory()->create();
        Machine::factory()->create();

        MaintenanceSheet::factory()->create();
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
                    'date',
                    'responsible',
                    'technical',
                    'description',
                    'maintenance_type'=>[
                        'name'
                    ],
                    'supplier'=>[
                        'name'
                    ],
                    'machine'=>[
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
        $maintenance_sheet = MaintenanceSheet::limit(1)->first();
//        dd($maintenance_sheet->id);
        $response = $this->actingAs($user)->withSession(['banned' => false])
            ->getJson("api/v1/$this->resource/$maintenance_sheet->id");

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [
                    'id',
                    'date',
                    'responsible',
                    'technical',
                    'description',
                    'maintenance_type'=>[
                        'name'
                    ],
                    'supplier'=>[
                        'name'
                    ],
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
            ->assertExactJson(['message' => "Unable to locate the maintenance sheet you requested."]);
    }

}

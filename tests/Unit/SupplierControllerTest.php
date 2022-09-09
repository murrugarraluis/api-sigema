<?php

namespace Tests\Unit;

use App\Models\DocumentType;
use App\Models\Supplier;
use App\Models\SupplierType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierControllerTest extends TestCase
{
    use RefreshDatabase;

    private $resource = 'suppliers';
    public function seedData()
    {
        DocumentType::factory()->create(['name' => 'RUC']);
        SupplierType::factory()->create(['name'=>'Proveedor de Servicios']);
        Supplier::factory(10)->create();
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
                    'phone',
                    'email',
                    'address',
                    'supplier_type' => [
                        'id',
                        'name'
                    ],
                    'document_type' => [
                        'id',
                        'name'
                    ],
                ]
            ]]);

    }
}

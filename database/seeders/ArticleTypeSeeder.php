<?php

namespace Database\Seeders;

use App\Models\ArticleType;
use Illuminate\Database\Seeder;

class ArticleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArticleType::factory()->create(['name'=>'Oficina']);
        ArticleType::factory()->create(['name'=>'Repuesto']);
        ArticleType::factory()->create(['name'=>'EPP']);
    }
}

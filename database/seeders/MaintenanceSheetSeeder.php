<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\MaintenanceSheet;
use Illuminate\Database\Seeder;

class MaintenanceSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = Article::inRandomOrder()->limit(5)->get();

        MaintenanceSheet::factory(10)
            ->hasAttached($articles, [
                'quantity' => 6,
                'price' => 40.5
            ])
            ->create();
    }
}

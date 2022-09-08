<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Machine;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $articles = Article::inRandomOrder()->limit(5)->get();
        Machine::factory(10)
            ->hasAttached($articles)
            ->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\WorkingSheet;
use Illuminate\Database\Seeder;

class WorkingSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkingSheet::factory(20)->create();
    }
}

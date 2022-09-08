<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Image;
use App\Models\Machine;
use App\Models\User;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee = Employee::limit(1)->first();
        $machine = Machine::limit(1)->first();
        Image::factory()->create([
            'imagable_type' => Employee::class,
            'imagable_id' => $employee,
        ]);
        Image::factory()->create([
            'imagable_type' => Machine::class,
            'imagable_id' => $machine,
        ]);
    }
}

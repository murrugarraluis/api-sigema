<?php

namespace Database\Seeders;

use App\Models\AttendanceSheet;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class AttendanceSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = Employee::all();
        AttendanceSheet::factory(5)
            ->hasAttached($employees, [
                "check_in" => '10:00:00',
                "check_out" => '15:00:00',
                "attendance" => true,
            ])
            ->create();
    }
}

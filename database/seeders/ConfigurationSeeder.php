<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Configuration::factory()->create(['name' => 'start_time_turn_one', "value" => '07:00:00']);
		Configuration::factory()->create(['name' => 'end_time_turn_one', "value" => '19:00:00']);

		Configuration::factory()->create(['name' => 'start_time_turn_two', "value" => '19:00:00']);
		Configuration::factory()->create(['name' => 'end_time_turn_two', "value" => '07:00:00']);

	}
}

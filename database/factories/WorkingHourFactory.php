<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WorkingHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'time_start' => $this->faker->time('H:i:s'),
            'time_end' => $this->faker->time('H:i:s'),
        ];
    }
}

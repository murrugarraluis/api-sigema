<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MachineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'serie_number' => "Serie - " . $this->faker->randomLetter() . $this->faker->randomNumber(5),
            'name' => "Machine " . $this->faker->randomLetter() . $this->faker->randomNumber(3),
            'brand' => "Brand " . $this->faker->randomLetter() . $this->faker->randomNumber(3),
            'model' => $this->faker->randomLetter() . "-" . $this->faker->randomNumber(3),
            'maximum_working_time' => 300,
            'time_worked' => $this->faker->numberBetween($min = 100, $max = 270),

        ];
    }
}

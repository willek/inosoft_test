<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MotorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tahun_keluaran' => $this->faker->numberBetween(1900, 2024),
            'warna' => $this->faker->colorName(),
            'harga' => $this->faker->numberBetween(0, 5000),
            'mesin' => $this->faker->text(10),
            'tipe_suspensi' => $this->faker->randomElement(['A/T', 'M/T']),
            'tipe_transmisi' => $this->faker->text(10),
        ];
    }
}

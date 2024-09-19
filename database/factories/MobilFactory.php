<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MobilFactory extends Factory
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
            'kapasitas_penumpang' => $this->faker->numberBetween(1, 8),
            'tipe' => $this->faker->text(10),
        ];
    }
}

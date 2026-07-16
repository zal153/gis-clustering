<?php

namespace Database\Factories;

use App\Models\Warga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Warga>
 */
class WargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => $this->faker->unique()->numerify('################'),
            'nama' => $this->faker->name(),
            'dusun' => $this->faker->randomElement(['CAMPOR', 'KOLPOH', 'TANA MERA']),
            'alamat' => $this->faker->address(),
            'pekerjaan' => $this->faker->jobTitle(),
            'latitude' => $this->faker->latitude(-6.9, -6.8),
            'longitude' => $this->faker->longitude(113.7, 113.8),
        ];
    }
}

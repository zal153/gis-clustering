<?php

namespace Database\Factories;

use App\Models\NilaiWarga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NilaiWarga>
 */
class NilaiWargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'warga_id' => \App\Models\Warga::factory(),
            'kriteria_id' => \App\Models\Kriteria::factory(),
            'nilai' => 500000.00,
            'nilai_normalisasi' => 2.00,
        ];
    }
}

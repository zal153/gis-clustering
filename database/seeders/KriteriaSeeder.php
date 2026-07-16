<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Kriteria::create([
            'kode' => 'C1',
            'nama' => 'Pendapatan',
            'bobot' => 35.00,
        ]);
        \App\Models\Kriteria::create([
            'kode' => 'C2',
            'nama' => 'Jumlah Tanggungan',
            'bobot' => 25.00,
        ]);
        \App\Models\Kriteria::create([
            'kode' => 'C3',
            'nama' => 'Pendidikan',
            'bobot' => 15.00,
        ]);
        \App\Models\Kriteria::create([
            'kode' => 'C4',
            'nama' => 'Kondisi Rumah',
            'bobot' => 25.00,
        ]);
    }
}

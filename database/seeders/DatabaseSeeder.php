<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach (
            [
                'hasil_clusterings',
                'nilai_wargas',
                'clustering_runs',
                'wargas',
                'kriterias',
                'users',
            ] as $table
        ) {
            DB::table($table)->truncate();
        }

        Schema::enableForeignKeyConstraints();

        User::factory()->create([
            'name' => 'Admin Operator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $this->call(KriteriaSeeder::class);
        $this->call(WargaSeeder::class);
        $this->call(NilaiWargaSeeder::class);
    }
}

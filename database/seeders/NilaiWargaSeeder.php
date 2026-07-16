<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use RuntimeException;

class NilaiWargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedTableFromDump('nilai_wargas');
    }

    private function seedTableFromDump(string $table): void
    {
        $dumpPath = base_path('gis_clustering.sql');
        $sql = file_get_contents($dumpPath);

        if ($sql === false) {
            throw new RuntimeException("Unable to read SQL dump: {$dumpPath}");
        }

        $pattern = '/INSERT INTO `' . preg_quote($table, '/') . '`.*?;\R\R/s';

        if (! preg_match($pattern, $sql, $matches)) {
            throw new RuntimeException("Missing INSERT statement for table: {$table}");
        }

        $statement = $matches[0];

        if (DB::getDriverName() === 'sqlite') {
            $statement = str_replace("\\'", "''", $statement);
        }

        DB::unprepared($statement);
    }
}

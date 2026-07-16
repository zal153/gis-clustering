<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\NilaiWarga;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Admin User
        User::factory()->create([
            'name' => 'Admin Operator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
        ]);

        // Seed Kriteria
        $this->call(KriteriaSeeder::class);

        $kriterias = Kriteria::all()->keyBy('kode');
        $c1 = $kriterias['C1'];
        $c2 = $kriterias['C2'];
        $c3 = $kriterias['C3'];
        $c4 = $kriterias['C4'];

        /**
         * Data Warga Desa Campor Barat – 73 KK Calon Penerima PKH
         *
         * Sumber: "Data Penelitian K-Means (1).xlsx"
         * Kolom C1-C4 adalah nilai normalisasi sesuai Dataset K-Means:
         *   C1 (Pendapatan):       1=<300rb, 2=300-600rb, 3=600rb-1jt
         *   C2 (Jml Tanggungan):   1-6 (raw value)
         *   C3 (Pendidikan):       0=Tdk Sekolah, 1=SD, 2=SMP/MTs, 3=SMA/SMK
         *   C4 (Kondisi Rumah):    1=Tdk Layak, 2=Kurang Layak, 3=Layak
         *
         * Koordinat GPS warga diambil dari "Data Penelitian K-Means (1).pdf".
         *
         * @var array{
         *   nama: string, nik: string, dusun: string, alamat: string, pekerjaan: string,
         *   lat: float, lng: float,
         *   c1_raw: int, c1_norm: int,
         *   c2_raw: int, c2_norm: int,
         *   c3_raw: int, c3_norm: int,
         *   c4_raw: int, c4_norm: int,
         * }[]
         */
        $tableWarga = [
            // ===== DUSUN CAMPOR (37 KK) =====
            [
                'nama' => 'AIDAH', 'nik' => '3527010101800001',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.96010, 'lng' => 113.14700,
                'c1_raw' => 911827, 'c1_norm' => 3, 'c2_raw' => 2, 'c2_norm' => 2, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'ALIRIDA', 'nik' => '3527010101800002',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.96025, 'lng' => 113.14720,
                'c1_raw' => 369796, 'c1_norm' => 2, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'ANJANI', 'nik' => '3527010101800003',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96040, 'lng' => 113.14740,
                'c1_raw' => 571680, 'c1_norm' => 2, 'c2_raw' => 1, 'c2_norm' => 1, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'ARFIYAH', 'nik' => '3527010101800004',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96055, 'lng' => 113.14760,
                'c1_raw' => 777939, 'c1_norm' => 3, 'c2_raw' => 1, 'c2_norm' => 1, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'EMMAR', 'nik' => '3527010101800005',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96070, 'lng' => 113.14780,
                'c1_raw' => 215531, 'c1_norm' => 1, 'c2_raw' => 3, 'c2_norm' => 3, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'HAIRUL UMAM', 'nik' => '3527010101800006',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.96085, 'lng' => 113.14800,
                'c1_raw' => 245625, 'c1_norm' => 1, 'c2_raw' => 6, 'c2_norm' => 6, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'HASANAH', 'nik' => '3527010101800007',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.96100, 'lng' => 113.14820,
                'c1_raw' => 215417, 'c1_norm' => 1, 'c2_raw' => 3, 'c2_norm' => 3, 'c3_raw' => 3, 'c3_norm' => 3, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'IDA ROYANI', 'nik' => '3527010101800008',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.96115, 'lng' => 113.14840,
                'c1_raw' => 375564, 'c1_norm' => 2, 'c2_raw' => 6, 'c2_norm' => 6, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'INSIYAH', 'nik' => '3527010101800009',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.96130, 'lng' => 113.14860,
                'c1_raw' => 854492, 'c1_norm' => 3, 'c2_raw' => 4, 'c2_norm' => 4, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'ISNANI', 'nik' => '3527010101800010',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.96145, 'lng' => 113.14880,
                'c1_raw' => 238849, 'c1_norm' => 1, 'c2_raw' => 6, 'c2_norm' => 6, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'KARIMAH', 'nik' => '3527010101800011',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.96160, 'lng' => 113.14900,
                'c1_raw' => 519822, 'c1_norm' => 2, 'c2_raw' => 2, 'c2_norm' => 2, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'KUSYANI', 'nik' => '3527010101800012',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.96175, 'lng' => 113.14920,
                'c1_raw' => 330723, 'c1_norm' => 2, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'LUJAIRIYAH', 'nik' => '3527010101800013',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96190, 'lng' => 113.14940,
                'c1_raw' => 761648, 'c1_norm' => 3, 'c2_raw' => 2, 'c2_norm' => 2, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'MAJJAD', 'nik' => '3527010101800014',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96205, 'lng' => 113.14960,
                'c1_raw' => 284948, 'c1_norm' => 1, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'MARKATI', 'nik' => '3527010101800015',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96220, 'lng' => 113.14980,
                'c1_raw' => 713778, 'c1_norm' => 3, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'MUALLIIMAH', 'nik' => '3527010101800016',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.96235, 'lng' => 113.15000,
                'c1_raw' => 777353, 'c1_norm' => 3, 'c2_raw' => 1, 'c2_norm' => 1, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'MUHMA', 'nik' => '3527010101800017',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96250, 'lng' => 113.15020,
                'c1_raw' => 344182, 'c1_norm' => 2, 'c2_raw' => 6, 'c2_norm' => 6, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'MUNA', 'nik' => '3527010101800018',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.96265, 'lng' => 113.15040,
                'c1_raw' => 526177, 'c1_norm' => 2, 'c2_raw' => 2, 'c2_norm' => 2, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'NAJIYAH', 'nik' => '3527010101800019',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96280, 'lng' => 113.15060,
                'c1_raw' => 830289, 'c1_norm' => 3, 'c2_raw' => 4, 'c2_norm' => 4, 'c3_raw' => 0, 'c3_norm' => 0, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'NURUL FITRIYAH', 'nik' => '3527010101800020',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.96295, 'lng' => 113.15080,
                'c1_raw' => 848338, 'c1_norm' => 3, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'PURIYA', 'nik' => '3527010101800021',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96310, 'lng' => 113.15100,
                'c1_raw' => 901579, 'c1_norm' => 3, 'c2_raw' => 3, 'c2_norm' => 3, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'RANIYAH', 'nik' => '3527010101800022',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96325, 'lng' => 113.15120,
                'c1_raw' => 386605, 'c1_norm' => 2, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'RIZKIYAH', 'nik' => '3527010101800023',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.96340, 'lng' => 113.15140,
                'c1_raw' => 502131, 'c1_norm' => 2, 'c2_raw' => 4, 'c2_norm' => 4, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'SABIRA', 'nik' => '3527010101800024',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.96355, 'lng' => 113.15160,
                'c1_raw' => 346512, 'c1_norm' => 2, 'c2_raw' => 3, 'c2_norm' => 3, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'SAMMIN', 'nik' => '3527010101800025',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96370, 'lng' => 113.15180,
                'c1_raw' => 941498, 'c1_norm' => 3, 'c2_raw' => 1, 'c2_norm' => 1, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'SITI AMINA', 'nik' => '3527010101800026',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.96385, 'lng' => 113.15200,
                'c1_raw' => 486311, 'c1_norm' => 2, 'c2_raw' => 6, 'c2_norm' => 6, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'SITI MARYAM', 'nik' => '3527010101800027',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96400, 'lng' => 113.15220,
                'c1_raw' => 514985, 'c1_norm' => 2, 'c2_raw' => 3, 'c2_norm' => 3, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'SITI RAMLAH', 'nik' => '3527010101800028',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.96415, 'lng' => 113.15240,
                'c1_raw' => 321341, 'c1_norm' => 2, 'c2_raw' => 1, 'c2_norm' => 1, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'SUHAINA', 'nik' => '3527010101800029',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96430, 'lng' => 113.15260,
                'c1_raw' => 531056, 'c1_norm' => 2, 'c2_raw' => 2, 'c2_norm' => 2, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => "SU'INNA", 'nik' => '3527010101800030',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96445, 'lng' => 113.15280,
                'c1_raw' => 707680, 'c1_norm' => 3, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'SUNAMI', 'nik' => '3527010101800031',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.96460, 'lng' => 113.15300,
                'c1_raw' => 596417, 'c1_norm' => 2, 'c2_raw' => 2, 'c2_norm' => 2, 'c3_raw' => 0, 'c3_norm' => 0, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'SUTRIYAH', 'nik' => '3527010101800032',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96475, 'lng' => 113.15320,
                'c1_raw' => 725945, 'c1_norm' => 3, 'c2_raw' => 1, 'c2_norm' => 1, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'UNSIYAH', 'nik' => '3527010101800033',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.96490, 'lng' => 113.15340,
                'c1_raw' => 218571, 'c1_norm' => 1, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'YULIANA', 'nik' => '3527010101800034',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.96505, 'lng' => 113.15360,
                'c1_raw' => 304805, 'c1_norm' => 2, 'c2_raw' => 1, 'c2_norm' => 1, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'IDHA', 'nik' => '3527010101800035',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.96520, 'lng' => 113.15380,
                'c1_raw' => 680151, 'c1_norm' => 3, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'HASANAH 2', 'nik' => '3527010101800036',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96535, 'lng' => 113.15400,
                'c1_raw' => 545011, 'c1_norm' => 2, 'c2_raw' => 6, 'c2_norm' => 6, 'c3_raw' => 0, 'c3_norm' => 0, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'MUHMA 2', 'nik' => '3527010101800037',
                'dusun' => 'CAMPOR', 'alamat' => 'Dusun Campor, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96550, 'lng' => 113.15420,
                'c1_raw' => 633605, 'c1_norm' => 3, 'c2_raw' => 2, 'c2_norm' => 2, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 2, 'c4_norm' => 2,
            ],

            // ===== DUSUN KOLPOH (20 KK) =====
            [
                'nama' => "BADI'AH", 'nik' => '3527010101800038',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95610, 'lng' => 113.14200,
                'c1_raw' => 699521, 'c1_norm' => 3, 'c2_raw' => 2, 'c2_norm' => 2, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'BUSIYA', 'nik' => '3527010101800039',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95625, 'lng' => 113.14220,
                'c1_raw' => 391328, 'c1_norm' => 2, 'c2_raw' => 3, 'c2_norm' => 3, 'c3_raw' => 0, 'c3_norm' => 0, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'DANIYA', 'nik' => '3527010101800040',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.95640, 'lng' => 113.14240,
                'c1_raw' => 241067, 'c1_norm' => 1, 'c2_raw' => 4, 'c2_norm' => 4, 'c3_raw' => 3, 'c3_norm' => 3, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'ESSUM', 'nik' => '3527010101800041',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95655, 'lng' => 113.14260,
                'c1_raw' => 569191, 'c1_norm' => 2, 'c2_raw' => 6, 'c2_norm' => 6, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'HENA', 'nik' => '3527010101800042',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.95670, 'lng' => 113.14280,
                'c1_raw' => 205004, 'c1_norm' => 1, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'HOSNI', 'nik' => '3527010101800043',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95685, 'lng' => 113.14300,
                'c1_raw' => 873321, 'c1_norm' => 3, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'MARTINI', 'nik' => '3527010101800044',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95700, 'lng' => 113.14320,
                'c1_raw' => 686611, 'c1_norm' => 3, 'c2_raw' => 3, 'c2_norm' => 3, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => "MASRI'A", 'nik' => '3527010101800045',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.95715, 'lng' => 113.14340,
                'c1_raw' => 351945, 'c1_norm' => 2, 'c2_raw' => 4, 'c2_norm' => 4, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'MUZDALIFAH', 'nik' => '3527010101800046',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.95730, 'lng' => 113.14360,
                'c1_raw' => 729973, 'c1_norm' => 3, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'NUR AINI', 'nik' => '3527010101800047',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.95745, 'lng' => 113.14380,
                'c1_raw' => 514213, 'c1_norm' => 2, 'c2_raw' => 4, 'c2_norm' => 4, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'PUSINAH', 'nik' => '3527010101800048',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95760, 'lng' => 113.14400,
                'c1_raw' => 807291, 'c1_norm' => 3, 'c2_raw' => 1, 'c2_norm' => 1, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'ROBHAYATI', 'nik' => '3527010101800049',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95775, 'lng' => 113.14420,
                'c1_raw' => 757763, 'c1_norm' => 3, 'c2_raw' => 3, 'c2_norm' => 3, 'c3_raw' => 0, 'c3_norm' => 0, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'RUWAIDA', 'nik' => '3527010101800050',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.95790, 'lng' => 113.14440,
                'c1_raw' => 401639, 'c1_norm' => 2, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'SAHMIYA', 'nik' => '3527010101800051',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95805, 'lng' => 113.14460,
                'c1_raw' => 900838, 'c1_norm' => 3, 'c2_raw' => 6, 'c2_norm' => 6, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'SITI', 'nik' => '3527010101800052',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.95820, 'lng' => 113.14480,
                'c1_raw' => 500958, 'c1_norm' => 2, 'c2_raw' => 3, 'c2_norm' => 3, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'SITI AISYAH', 'nik' => '3527010101800053',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95835, 'lng' => 113.14500,
                'c1_raw' => 607289, 'c1_norm' => 3, 'c2_raw' => 1, 'c2_norm' => 1, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'SITI MAISUNA', 'nik' => '3527010101800054',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.95850, 'lng' => 113.14520,
                'c1_raw' => 525045, 'c1_norm' => 2, 'c2_raw' => 6, 'c2_norm' => 6, 'c3_raw' => 3, 'c3_norm' => 3, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'SITI NUR DINA', 'nik' => '3527010101800055',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95865, 'lng' => 113.14540,
                'c1_raw' => 602581, 'c1_norm' => 3, 'c2_raw' => 3, 'c2_norm' => 3, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'SITTIYA', 'nik' => '3527010101800056',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.95880, 'lng' => 113.14560,
                'c1_raw' => 833636, 'c1_norm' => 3, 'c2_raw' => 2, 'c2_norm' => 2, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'TASLIMA', 'nik' => '3527010101800057',
                'dusun' => 'KOLPOH', 'alamat' => 'Dusun Kolpoh, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95895, 'lng' => 113.14580,
                'c1_raw' => 643762, 'c1_norm' => 3, 'c2_raw' => 1, 'c2_norm' => 1, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 2, 'c4_norm' => 2,
            ],

            // ===== DUSUN TANA MERA (16 KK) =====
            [
                'nama' => 'BAITUR ROHMAH', 'nik' => '3527010101800058',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95810, 'lng' => 113.15000,
                'c1_raw' => 645123, 'c1_norm' => 3, 'c2_raw' => 4, 'c2_norm' => 4, 'c3_raw' => 0, 'c3_norm' => 0, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'ERNA NINGSIH', 'nik' => '3527010101800059',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95825, 'lng' => 113.15020,
                'c1_raw' => 820456, 'c1_norm' => 3, 'c2_raw' => 4, 'c2_norm' => 4, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'HANIFAH', 'nik' => '3527010101800060',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.95840, 'lng' => 113.15040,
                'c1_raw' => 178932, 'c1_norm' => 1, 'c2_raw' => 1, 'c2_norm' => 1, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'HANIYA', 'nik' => '3527010101800061',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.95855, 'lng' => 113.15060,
                'c1_raw' => 312456, 'c1_norm' => 2, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'JUSA', 'nik' => '3527010101800062',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95870, 'lng' => 113.15080,
                'c1_raw' => 198765, 'c1_norm' => 1, 'c2_raw' => 6, 'c2_norm' => 6, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'LIMA', 'nik' => '3527010101800063',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.95885, 'lng' => 113.15100,
                'c1_raw' => 267890, 'c1_norm' => 1, 'c2_raw' => 4, 'c2_norm' => 4, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'MARWATI', 'nik' => '3527010101800064',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95900, 'lng' => 113.15120,
                'c1_raw' => 423567, 'c1_norm' => 2, 'c2_raw' => 4, 'c2_norm' => 4, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'MUHRIMA', 'nik' => '3527010101800065',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.95915, 'lng' => 113.15140,
                'c1_raw' => 589234, 'c1_norm' => 2, 'c2_raw' => 4, 'c2_norm' => 4, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'NATUN', 'nik' => '3527010101800066',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95930, 'lng' => 113.15160,
                'c1_raw' => 512345, 'c1_norm' => 2, 'c2_raw' => 1, 'c2_norm' => 1, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'NURUL HAYATI', 'nik' => '3527010101800067',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.95945, 'lng' => 113.15180,
                'c1_raw' => 478923, 'c1_norm' => 2, 'c2_raw' => 1, 'c2_norm' => 1, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'PUSARIYAH', 'nik' => '3527010101800068',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95960, 'lng' => 113.15200,
                'c1_raw' => 756789, 'c1_norm' => 3, 'c2_raw' => 3, 'c2_norm' => 3, 'c3_raw' => 0, 'c3_norm' => 0, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'RA ENA', 'nik' => '3527010101800069',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.95975, 'lng' => 113.15220,
                'c1_raw' => 234567, 'c1_norm' => 1, 'c2_raw' => 6, 'c2_norm' => 6, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'RUHAMA', 'nik' => '3527010101800070',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.95990, 'lng' => 113.15240,
                'c1_raw' => 867890, 'c1_norm' => 3, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
            [
                'nama' => 'RUSNA', 'nik' => '3527010101800071',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Pedagang',
                'lat' => -6.96005, 'lng' => 113.15260,
                'c1_raw' => 356789, 'c1_norm' => 2, 'c2_raw' => 4, 'c2_norm' => 4, 'c3_raw' => 1, 'c3_norm' => 1, 'c4_raw' => 3, 'c4_norm' => 3,
            ],
            [
                'nama' => 'SAHRIYA', 'nik' => '3527010101800072',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Buruh',
                'lat' => -6.96020, 'lng' => 113.15280,
                'c1_raw' => 589012, 'c1_norm' => 2, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 0, 'c3_norm' => 0, 'c4_raw' => 2, 'c4_norm' => 2,
            ],
            [
                'nama' => 'SUTIMA', 'nik' => '3527010101800073',
                'dusun' => 'TANA MERA', 'alamat' => 'Dusun Tana Mera, Desa Campor Barat', 'pekerjaan' => 'Petani',
                'lat' => -6.96035, 'lng' => 113.15300,
                'c1_raw' => 812345, 'c1_norm' => 3, 'c2_raw' => 5, 'c2_norm' => 5, 'c3_raw' => 2, 'c3_norm' => 2, 'c4_raw' => 1, 'c4_norm' => 1,
            ],
        ];

        /** @var array<string, array{latitude: float, longitude: float}> $coordinatesByNik */
        $coordinatesByNik = [
            '3527010101800001' => ['latitude' => -6.887385, 'longitude' => 113.758617],
            '3527010101800002' => ['latitude' => -6.887016, 'longitude' => 113.762057],
            '3527010101800003' => ['latitude' => -6.886322, 'longitude' => 113.758898],
            '3527010101800004' => ['latitude' => -6.886535, 'longitude' => 113.759820],
            '3527010101800005' => ['latitude' => -6.886562, 'longitude' => 113.758910],
            '3527010101800006' => ['latitude' => -6.887703, 'longitude' => 113.759026],
            '3527010101800007' => ['latitude' => -6.887703, 'longitude' => 113.759026],
            '3527010101800008' => ['latitude' => -6.890947, 'longitude' => 113.761755],
            '3527010101800009' => ['latitude' => -6.891092, 'longitude' => 113.762733],
            '3527010101800010' => ['latitude' => -6.890987, 'longitude' => 113.761362],
            '3527010101800011' => ['latitude' => -6.889774, 'longitude' => 113.760564],
            '3527010101800012' => ['latitude' => -6.887740, 'longitude' => 113.759800],
            '3527010101800013' => ['latitude' => -6.887221, 'longitude' => 113.759882],
            '3527010101800014' => ['latitude' => -6.886368, 'longitude' => 113.755975],
            '3527010101800015' => ['latitude' => -6.888317, 'longitude' => 113.759483],
            '3527010101800016' => ['latitude' => -6.889783, 'longitude' => 113.762838],
            '3527010101800017' => ['latitude' => -6.887072, 'longitude' => 113.762952],
            '3527010101800018' => ['latitude' => -6.889820, 'longitude' => 113.761000],
            '3527010101800019' => ['latitude' => -6.887507, 'longitude' => 113.759693],
            '3527010101800020' => ['latitude' => -6.888642, 'longitude' => 113.760573],
            '3527010101800021' => ['latitude' => -6.888642, 'longitude' => 113.760573],
            '3527010101800022' => ['latitude' => -6.889783, 'longitude' => 113.762838],
            '3527010101800023' => ['latitude' => -6.888317, 'longitude' => 113.759483],
            '3527010101800024' => ['latitude' => -6.887587, 'longitude' => 113.764167],
            '3527010101800025' => ['latitude' => -6.889107, 'longitude' => 113.761054],
            '3527010101800026' => ['latitude' => -6.889107, 'longitude' => 113.761054],
            '3527010101800027' => ['latitude' => -6.888662, 'longitude' => 113.759338],
            '3527010101800028' => ['latitude' => -6.886438, 'longitude' => 113.756438],
            '3527010101800029' => ['latitude' => -6.887762, 'longitude' => 113.759320],
            '3527010101800030' => ['latitude' => -6.889865, 'longitude' => 113.761595],
            '3527010101800031' => ['latitude' => -6.886597, 'longitude' => 113.758240],
            '3527010101800032' => ['latitude' => -6.887221, 'longitude' => 113.759882],
            '3527010101800033' => ['latitude' => -6.888882, 'longitude' => 113.760018],
            '3527010101800034' => ['latitude' => -6.889547, 'longitude' => 113.763642],
            '3527010101800035' => ['latitude' => -6.888662, 'longitude' => 113.759338],
            '3527010101800036' => ['latitude' => -6.887888, 'longitude' => 113.759348],
            '3527010101800037' => ['latitude' => -6.888662, 'longitude' => 113.759338],
            '3527010101800038' => ['latitude' => -6.885996, 'longitude' => 113.751135],
            '3527010101800039' => ['latitude' => -6.886969, 'longitude' => 113.749875],
            '3527010101800040' => ['latitude' => -6.889310, 'longitude' => 113.750264],
            '3527010101800041' => ['latitude' => -6.890093, 'longitude' => 113.750016],
            '3527010101800042' => ['latitude' => -6.890265, 'longitude' => 113.749263],
            '3527010101800043' => ['latitude' => -6.891193, 'longitude' => 113.748784],
            '3527010101800044' => ['latitude' => -6.891273, 'longitude' => 113.748818],
            '3527010101800045' => ['latitude' => -6.893272, 'longitude' => 113.748929],
            '3527010101800046' => ['latitude' => -6.892312, 'longitude' => 113.748158],
            '3527010101800047' => ['latitude' => -6.892218, 'longitude' => 113.748744],
            '3527010101800048' => ['latitude' => -6.891648, 'longitude' => 113.747315],
            '3527010101800049' => ['latitude' => -6.891527, 'longitude' => 113.746558],
            '3527010101800050' => ['latitude' => -6.891903, 'longitude' => 113.748688],
            '3527010101800051' => ['latitude' => -6.890074, 'longitude' => 113.749190],
            '3527010101800052' => ['latitude' => -6.891193, 'longitude' => 113.748784],
            '3527010101800053' => ['latitude' => -6.886418, 'longitude' => 113.750993],
            '3527010101800054' => ['latitude' => -6.886418, 'longitude' => 113.750993],
            '3527010101800055' => ['latitude' => -6.888735, 'longitude' => 113.750458],
            '3527010101800056' => ['latitude' => -6.891903, 'longitude' => 113.748688],
            '3527010101800057' => ['latitude' => -6.891527, 'longitude' => 113.746558],
            '3527010101800058' => ['latitude' => -6.900580, 'longitude' => 113.763930],
            '3527010101800059' => ['latitude' => -6.900712, 'longitude' => 113.763348],
            '3527010101800060' => ['latitude' => -6.900617, 'longitude' => 113.763812],
            '3527010101800061' => ['latitude' => -6.900805, 'longitude' => 113.762145],
            '3527010101800062' => ['latitude' => -6.900852, 'longitude' => 113.762077],
            '3527010101800063' => ['latitude' => -6.900852, 'longitude' => 113.762077],
            '3527010101800064' => ['latitude' => -6.897956, 'longitude' => 113.762604],
            '3527010101800065' => ['latitude' => -6.897232, 'longitude' => 113.761366],
            '3527010101800066' => ['latitude' => -6.903203, 'longitude' => 113.760935],
            '3527010101800067' => ['latitude' => -6.897635, 'longitude' => 113.764762],
            '3527010101800068' => ['latitude' => -6.897597, 'longitude' => 113.764388],
            '3527010101800069' => ['latitude' => -6.897070, 'longitude' => 113.765593],
            '3527010101800070' => ['latitude' => -6.897070, 'longitude' => 113.765593],
            '3527010101800071' => ['latitude' => -6.900580, 'longitude' => 113.763930],
            '3527010101800072' => ['latitude' => -6.898579, 'longitude' => 113.762239],
            '3527010101800073' => ['latitude' => -6.898450, 'longitude' => 113.762267],
        ];

        foreach ($tableWarga as $w) {
            $coordinate = $coordinatesByNik[$w['nik']];

            $warga = Warga::create([
                'nik' => $w['nik'],
                'nama' => $w['nama'],
                'dusun' => $w['dusun'],
                'alamat' => $w['alamat'],
                'pekerjaan' => $w['pekerjaan'],
                'latitude' => $coordinate['latitude'],
                'longitude' => $coordinate['longitude'],
            ]);

            NilaiWarga::create([
                'warga_id' => $warga->id,
                'kriteria_id' => $c1->id,
                'nilai' => $w['c1_raw'],
                'nilai_normalisasi' => $w['c1_norm'],
            ]);

            NilaiWarga::create([
                'warga_id' => $warga->id,
                'kriteria_id' => $c2->id,
                'nilai' => $w['c2_raw'],
                'nilai_normalisasi' => $w['c2_norm'],
            ]);

            NilaiWarga::create([
                'warga_id' => $warga->id,
                'kriteria_id' => $c3->id,
                'nilai' => $w['c3_raw'],
                'nilai_normalisasi' => $w['c3_norm'],
            ]);

            NilaiWarga::create([
                'warga_id' => $warga->id,
                'kriteria_id' => $c4->id,
                'nilai' => $w['c4_raw'],
                'nilai_normalisasi' => $w['c4_norm'],
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Warga;
use App\Models\Kriteria;
use App\Models\ClusteringRun;
use App\Models\HasilClustering;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $latestRun = ClusteringRun::query()->orderBy('run_date', 'desc')->first();

        $rawWargas = Warga::query()->with(['nilaiWargas.kriteria'])->get();
        $totalWarga = $rawWargas->count();
        $totalKriteria = Kriteria::query()->count('id');

        $wargas = $rawWargas->map(function ($warga) use ($latestRun) {
            $clusterAssignment = null;
            if ($latestRun) {
                $hasil = $warga->hasilClusterings()->where(['clustering_run_id' => $latestRun->id])->first();
                if ($hasil) {
                    $clusterAssignment = $hasil->cluster_number;
                }
            }
            return [
                'id' => $warga->id,
                'nik' => $warga->nik,
                'nama' => $warga->nama,
                'alamat' => $warga->alamat,
                'latitude' => $warga->latitude,
                'longitude' => $warga->longitude,
                'cluster' => $clusterAssignment,
                'nilai' => $warga->nilaiWargas->map(function ($nilai) {
                    return [
                        'kriteria_kode' => $nilai->kriteria->kode,
                        'kriteria_nama' => $nilai->kriteria->nama,
                        'nilai' => $nilai->nilai,
                        'nilai_normalisasi' => $nilai->nilai_normalisasi,
                    ];
                })
            ];
        });

        // Hitung persebaran cluster untuk stats ringkasan
        $clusterCounts = [];
        if ($latestRun) {
            for ($i = 0; $i < $latestRun->k_value; $i++) {
                $clusterCounts[$i] = HasilClustering::query()->where([
                    'clustering_run_id' => $latestRun->id,
                    'cluster_number' => $i,
                ])->count('id');
            }
        }

        return view('dashboard.index', compact('totalWarga', 'totalKriteria', 'latestRun', 'wargas', 'clusterCounts'));
    }
}

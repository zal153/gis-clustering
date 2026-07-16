<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\ClusteringRun;
use App\Models\HasilClustering;
use App\Services\ClusteringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClusteringController extends Controller
{
    protected $clusteringService;

    public function __construct(ClusteringService $clusteringService)
    {
        $this->clusteringService = $clusteringService;
    }

    /**
     * Display the form to select K and execute clustering.
     */
    public function index()
    {
        $totalWarga = DB::table('wargas')->count('id');
        $latestRun = ClusteringRun::query()
            ->orderBy("run_date", "desc")
            ->first();
        return view('kmeans.index', compact('totalWarga', 'latestRun'));
    }

    /**
     * Run K-Means algorithm and save/show details.
     */
    public function run(Request $request)
    {
        $request->validate(
            [
                "k" => "required|integer|min:2|max:5",
            ],
            [
                "k.min" => "Jumlah klaster minimal adalah 2.",
                "k.max" => "Jumlah klaster maksimal adalah 5.",
            ],
        );

        $k = $request->k;
        $wargas = Warga::with([
            "nilaiWargas.kriteria" => function ($q) {
                $q->orderBy("kode", "asc");
            },
        ])->get();

        if ($wargas->count() < $k) {
            return redirect()
                ->back()
                ->with("error", "Jumlah warga terdaftar kurang dari nilai K.");
        }

        $dataset = [];
        foreach ($wargas as $warga) {
            $nilaiMapped = $warga->nilaiWargas->keyBy("kriteria.kode");
            $c1 = isset($nilaiMapped["C1"])
                ? (float) $nilaiMapped["C1"]->nilai_normalisasi
                : 1.0;
            $c2 = isset($nilaiMapped["C2"])
                ? (float) $nilaiMapped["C2"]->nilai_normalisasi
                : 1.0;
            $c3 = isset($nilaiMapped["C3"])
                ? (float) $nilaiMapped["C3"]->nilai_normalisasi
                : 1.0;
            $c4 = isset($nilaiMapped["C4"])
                ? (float) $nilaiMapped["C4"]->nilai_normalisasi
                : 1.0;

            $dataset[] = [
                "id" => $warga->id,
                "nama" => $warga->nama,
                "values" => [$c1, $c2, $c3, $c4],
            ];
        }

        $result = $this->clusteringService->run($dataset, $k);

        if (!$result["success"]) {
            return redirect()->back()->with("error", $result["message"]);
        }

        $run = null;
        DB::transaction(function () use ($result, $k, $dataset, &$run) {
            $run = ClusteringRun::query()->create([
                "k_value" => $k,
                "silhouette_score" => $result["silhouette_score"],
                "jumlah_data" => count($dataset),
                "metode" => "K-Means",
                "run_date" => now(),
            ]);

            foreach ($result["assignments"] as $assign) {
                HasilClustering::query()->create([
                    "clustering_run_id" => $run->id,
                    "warga_id" => $assign["warga_id"],
                    "cluster_number" => $assign["cluster"],
                    "jarak_centroid" => $assign["distance"],
                ]);
            }
        });

        // Simpan hasil kalkulasi iterasi detail ke session untuk ditampilkan sekali
        return view("kmeans.result", compact("result", "run"));
    }

    /**
     * Show history of clustering runs.
     */
    public function history()
    {
        $runs = ClusteringRun::orderBy("run_date", "desc")->get();
        return view("kmeans.history", compact("runs"));
    }

    /**
     * Show detailed assignments for a specific run.
     */
    public function showRun(ClusteringRun $run)
    {
        $hasil = HasilClustering::query()
            ->with("warga.nilaiWargas.kriteria")
            ->where(["clustering_run_id" => $run->id])
            ->get();

        return view("kmeans.show", compact("run", "hasil"));
    }

    /**
     * Display the Silhouette Score comparison page.
     */
    public function silhouetteComparison()
    {
        $totalWarga = DB::table('wargas')->count('id');
        return view('kmeans.silhouette', compact('totalWarga'));
    }

    /**
     * Process Silhouette Score comparison for K=2 to K=5.
     */
    public function processSilhouetteComparison()
    {
        $wargas = Warga::with([
            "nilaiWargas.kriteria" => function ($q) {
                $q->orderBy("kode", "asc");
            },
        ])->get();

        $maxK = min(5, $wargas->count());
        if ($maxK < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah warga terdaftar kurang untuk melakukan analisis perbandingan K (minimal 2 warga).',
            ]);
        }

        $dataset = [];
        foreach ($wargas as $warga) {
            $nilaiMapped = $warga->nilaiWargas->keyBy("kriteria.kode");
            $c1 = isset($nilaiMapped["C1"]) ? (float) $nilaiMapped["C1"]->nilai_normalisasi : 1.0;
            $c2 = isset($nilaiMapped["C2"]) ? (float) $nilaiMapped["C2"]->nilai_normalisasi : 1.0;
            $c3 = isset($nilaiMapped["C3"]) ? (float) $nilaiMapped["C3"]->nilai_normalisasi : 1.0;
            $c4 = isset($nilaiMapped["C4"]) ? (float) $nilaiMapped["C4"]->nilai_normalisasi : 1.0;

            $dataset[] = [
                "id" => $warga->id,
                "nama" => $warga->nama,
                "values" => [$c1, $c2, $c3, $c4],
            ];
        }

        $results = [];
        for ($k = 2; $k <= $maxK; $k++) {
            $startTime = microtime(true);
            $res = $this->clusteringService->run($dataset, $k);
            $duration = round((microtime(true) - $startTime) * 1000, 2);

            if ($res['success']) {
                $score = $res['silhouette_score'];
                if ($score > 0.70) {
                    $quality = 'Sangat Kuat';
                    $class = 'success';
                } elseif ($score > 0.50) {
                    $quality = 'Sedang';
                    $class = 'info';
                } elseif ($score > 0.25) {
                    $quality = 'Lemah';
                    $class = 'warning';
                } else {
                    $quality = 'Sangat Lemah / Tidak Valid';
                    $class = 'danger';
                }

                $results[] = [
                    'k' => $k,
                    'silhouette_score' => $score,
                    'quality' => $quality,
                    'quality_class' => $class,
                    'iterations' => $res['iterations_count'],
                    'duration' => $duration,
                ];
            }
        }

        $optimalK = null;
        $highestScore = -2.0;
        foreach ($results as $r) {
            if ($r['silhouette_score'] > $highestScore) {
                $highestScore = $r['silhouette_score'];
                $optimalK = $r['k'];
            }
        }

        return response()->json([
            'success' => true,
            'results' => $results,
            'optimal_k' => $optimalK,
        ]);
    }
}

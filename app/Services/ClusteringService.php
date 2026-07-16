<?php

namespace App\Services;

class ClusteringService
{
    /**
     * Jalankan Algoritma K-Means Clustering.
     *
     * @param array $dataset Data warga dengan kriteria dinormalisasi, format: [['id' => 1, 'values' => [3, 2, 2, 2]], ...]
     * @param int $k Jumlah cluster
     * @param int $maxIterations Batas maksimal iterasi untuk menghindari infinite loop
     * @return array
     */
    public function run(array $dataset, int $k, int $maxIterations = 100): array
    {
        if (count($dataset) < $k || $k < 1) {
            return [
                'success' => false,
                'message' => 'Jumlah data kurang dari K atau K tidak valid.',
            ];
        }

        // 1. Inisialisasi Centroid Awal
        // Menyesuaikan dengan Bab 3 & Bab 4 proposal/skripsi agar hasil perhitungan
        // konsisten dengan simulasi manual dan hasil sistem yang dilaporkan.
        $centroids = [];
        if ($k === 3) {
            $c1 = $this->findDataByName($dataset, 'AIDAH');
            $c2 = $this->findDataByName($dataset, 'MUHMA 2') ?? $this->findDataByName($dataset, 'MUHMA');
            $c3 = $this->findDataByName($dataset, 'SUTIMA');

            if ($c1 && $c2 && $c3) {
                $centroids[0] = $c1['values'];
                $centroids[1] = $c2['values'];
                $centroids[2] = $c3['values'];
            }
        } elseif ($k === 2) {
            $c1 = $this->findDataByName($dataset, 'AIDAH');
            $c2 = $this->findDataByName($dataset, 'ANJANI');

            if ($c1 && $c2) {
                $centroids[0] = $c1['values'];
                $centroids[1] = $c2['values'];
            }
        }

        // Fallback jika tidak menemukan nama data yang sesuai (misal pada unit test)
        if (count($centroids) < $k) {
            $centroids = [];
            for ($i = 0; $i < $k; $i++) {
                $centroids[$i] = $dataset[$i]['values'];
            }
        }

        $history = [];
        $converged = false;
        $iteration = 0;
        $assignments = [];
        $currentAssignments = [];

        while (!$converged && $iteration < $maxIterations) {
            $iteration++;
            $currentAssignments = [];
            $clusterGroups = array_fill(0, $k, []);

            // 2. Hitung Jarak dan Asosiasikan ke Cluster Terdekat
            foreach ($dataset as $dataIndex => $data) {
                $distances = [];
                foreach ($centroids as $cIndex => $centroid) {
                    $distances[$cIndex] = $this->calculateEuclideanDistance($data['values'], $centroid);
                }

                // Cari cluster terdekat (jarak minimum)
                asort($distances);
                $nearestCluster = key($distances);
                $minDistance = current($distances);

                $currentAssignments[$dataIndex] = [
                    'warga_id' => $data['id'],
                    'warga_nama' => $data['nama'],
                    'values' => $data['values'],
                    'cluster' => $nearestCluster,
                    'distance' => $minDistance,
                    'distances' => $distances, // Simpan semua jarak untuk visualisasi detail iterasi
                ];

                $clusterGroups[$nearestCluster][] = $data['values'];
            }

            // 3. Hitung Centroid Baru (Rata-rata anggota cluster)
            $newCentroids = [];
            for ($i = 0; $i < $k; $i++) {
                if (count($clusterGroups[$i]) > 0) {
                    $newCentroids[$i] = $this->calculateCentroidMean($clusterGroups[$i]);
                } else {
                    // Jika cluster kosong, tetap gunakan centroid lama
                    $newCentroids[$i] = $centroids[$i];
                }
            }

            // Simpan riwayat iterasi ini
            $history[] = [
                'iteration' => $iteration,
                'centroids' => $centroids,
                'assignments' => $currentAssignments,
            ];

            // 4. Periksa Konvergensi (Apakah centroid berubah?)
            $centroidsChanged = false;
            for ($i = 0; $i < $k; $i++) {
                if ($this->calculateEuclideanDistance($centroids[$i], $newCentroids[$i]) > 0.000001) {
                    $centroidsChanged = true;
                    break;
                }
            }

            if (!$centroidsChanged) {
                $converged = true;
                $assignments = $currentAssignments;
            } else {
                $centroids = $newCentroids;
            }
        }

        // Jika mencapai batas iterasi tanpa konvergen secara penuh, ambil hasil terakhir
        if (empty($assignments)) {
            $assignments = $currentAssignments;
        }

        // 5. Hitung Silhouette Score untuk mengevaluasi hasil clustering
        $silhouetteScore = $this->calculateSilhouetteScore($assignments, $k);

        return [
            'success' => true,
            'k' => $k,
            'iterations_count' => $iteration,
            'final_centroids' => $centroids,
            'assignments' => $assignments,
            'silhouette_score' => $silhouetteScore,
            'history' => $history,
        ];
    }

    /**
     * Hitung Jarak Euclidean antara dua array.
     */
    private function calculateEuclideanDistance(array $point1, array $point2): float
    {
        $sum = 0.0;
        $count = count($point1);
        for ($i = 0; $i < $count; $i++) {
            $diff = $point1[$i] - $point2[$i];
            $sum += $diff * $diff;
        }
        return sqrt($sum);
    }

    /**
     * Hitung rata-rata titik untuk koordinat Centroid baru.
     */
    private function calculateCentroidMean(array $points): array
    {
        $count = count($points);
        $dimensions = count($points[0]);
        $means = array_fill(0, $dimensions, 0.0);

        foreach ($points as $point) {
            for ($d = 0; $d < $dimensions; $d++) {
                $means[$d] += $point[$d];
            }
        }

        for ($d = 0; $d < $dimensions; $d++) {
            $means[$d] = round($means[$d] / $count, 4);
        }

        return $means;
    }

    /**
     * Hitung Silhouette Score.
     * S(i) = (b(i) - a(i)) / max(a(i), b(i))
     */
    private function calculateSilhouetteScore(array $assignments, int $k): float
    {
        $totalPoints = count($assignments);
        if ($totalPoints <= $k || $k <= 1) {
            return 0.0;
        }

        // Kelompokkan assignment berdasarkan cluster
        $clusters = [];
        foreach ($assignments as $index => $item) {
            $clusters[$item['cluster']][] = [
                'index' => $index,
                'values' => $item['values'],
            ];
        }

        $silhouetteScores = [];

        foreach ($assignments as $i => $item) {
            $currentCluster = $item['cluster'];
            $iValues = $item['values'];

            // 1. Hitung a(i) - rata-rata jarak ke semua titik lain dalam cluster yang sama
            $sameClusterPoints = $clusters[$currentCluster];
            $a_i = 0.0;
            $sameCount = count($sameClusterPoints);

            if ($sameCount > 1) {
                $sumDist = 0.0;
                foreach ($sameClusterPoints as $otherPoint) {
                    if ($otherPoint['index'] !== $i) {
                        $sumDist += $this->calculateEuclideanDistance($iValues, $otherPoint['values']);
                    }
                }
                $a_i = $sumDist / ($sameCount - 1);
            } else {
                $a_i = 0.0; // Jika hanya ada satu titik di cluster
            }

            // 2. Hitung b(i) - rata-rata jarak minimum ke cluster lain
            $minAverageDistToOtherCluster = INF;

            for ($c = 0; $c < $k; $c++) {
                if ($c === $currentCluster || !isset($clusters[$c]) || empty($clusters[$c])) {
                    continue;
                }

                $otherClusterPoints = $clusters[$c];
                $sumDist = 0.0;
                foreach ($otherClusterPoints as $otherPoint) {
                    $sumDist += $this->calculateEuclideanDistance($iValues, $otherPoint['values']);
                }
                $avgDist = $sumDist / count($otherClusterPoints);

                if ($avgDist < $minAverageDistToOtherCluster) {
                    $minAverageDistToOtherCluster = $avgDist;
                }
            }

            $b_i = $minAverageDistToOtherCluster;

            // 3. S(i) = (b(i) - a(i)) / max(a(i), b(i))
            if ($sameCount <= 1) {
                $s_i = 0.0;
            } else {
                $max_ab = max($a_i, $b_i);
                if ($max_ab > 0) {
                    $s_i = ($b_i - $a_i) / $max_ab;
                } else {
                    $s_i = 0.0;
                }
            }

            $silhouetteScores[] = $s_i;
        }

        // Rata-rata dari semua silhouette score
        return round(array_sum($silhouetteScores) / $totalPoints, 4);
    }

    /**
     * Cari data berdasarkan nama warga (case-insensitive).
     */
    private function findDataByName(array $dataset, string $name): ?array
    {
        foreach ($dataset as $data) {
            if (strcasecmp(trim($data['nama']), trim($name)) === 0) {
                return $data;
            }
        }
        return null;
    }
}

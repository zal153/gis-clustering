<?php

use App\Services\ClusteringService;

test('k-means clustering matches the proposal manual simulation', function () {
    $service = new ClusteringService();

    // Data sampel dari Tabel 3.4
    $dataset = [
        [
            'id' => 1,
            'nama' => 'Aidah',
            'values' => [3.0, 2.0, 2.0, 2.0], // C1
        ],
        [
            'id' => 3,
            'nama' => 'Anjani',
            'values' => [2.0, 1.0, 1.0, 1.0], // C2
        ],
        [
            'id' => 2,
            'nama' => 'Alirida',
            'values' => [3.0, 5.0, 2.0, 2.0],
        ],
    ];

    $result = $service->run($dataset, 2);

    expect($result['success'])->toBeTrue();
    expect($result['iterations_count'])->toBe(2); // Selesai dalam 2 iterasi

    $assignments = $result['assignments'];

    // Aidah (id=1) harus masuk cluster 0 (Centroid 1)
    expect($assignments[0]['cluster'])->toBe(0);
    expect($assignments[0]['distance'])->toBe(1.5); // Di iterasi kedua, jarak Aidah ke centroid baru C1(3, 3.5, 2, 2) adalah 1.5

    // Anjani (id=3) harus masuk cluster 1 (Centroid 2)
    expect($assignments[1]['cluster'])->toBe(1);
    expect($assignments[1]['distance'])->toBe(0.0); // Jarak Anjani ke centroid C2(2, 1, 1, 1) adalah 0

    // Alirida (id=2) harus masuk cluster 0 (Centroid 1)
    expect($assignments[2]['cluster'])->toBe(0);
    expect($assignments[2]['distance'])->toBe(1.5); // Jarak Alirida ke centroid baru C1(3, 3.5, 2, 2) adalah 1.5
});

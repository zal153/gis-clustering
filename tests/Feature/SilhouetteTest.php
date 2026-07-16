<?php

use App\Models\User;
use App\Models\Warga;
use App\Models\Kriteria;
use App\Models\NilaiWarga;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests are redirected to login when accessing silhouette page', function () {
    $response = $this->get('/clustering/silhouette');
    $response->assertRedirect('/login');
});

test('authenticated users can view the silhouette comparison page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/clustering/silhouette');
    $response->assertStatus(200);
    $response->assertSee('Silhouette');
});

test('authenticated users can process silhouette comparison and get json results', function () {
    $user = User::factory()->create();

    // Seed Kriteria C1 - C4
    $c1 = Kriteria::factory()->create(['kode' => 'C1']);
    $c2 = Kriteria::factory()->create(['kode' => 'C2']);
    $c3 = Kriteria::factory()->create(['kode' => 'C3']);
    $c4 = Kriteria::factory()->create(['kode' => 'C4']);

    // Seed at least 2 Warga
    $warga1 = Warga::factory()->create();
    $warga2 = Warga::factory()->create();

    // Seed NilaiWarga for both
    NilaiWarga::factory()->create(['warga_id' => $warga1->id, 'kriteria_id' => $c1->id, 'nilai_normalisasi' => 3.0]);
    NilaiWarga::factory()->create(['warga_id' => $warga1->id, 'kriteria_id' => $c2->id, 'nilai_normalisasi' => 2.0]);
    NilaiWarga::factory()->create(['warga_id' => $warga1->id, 'kriteria_id' => $c3->id, 'nilai_normalisasi' => 2.0]);
    NilaiWarga::factory()->create(['warga_id' => $warga1->id, 'kriteria_id' => $c4->id, 'nilai_normalisasi' => 2.0]);

    NilaiWarga::factory()->create(['warga_id' => $warga2->id, 'kriteria_id' => $c1->id, 'nilai_normalisasi' => 1.0]);
    NilaiWarga::factory()->create(['warga_id' => $warga2->id, 'kriteria_id' => $c2->id, 'nilai_normalisasi' => 1.0]);
    NilaiWarga::factory()->create(['warga_id' => $warga2->id, 'kriteria_id' => $c3->id, 'nilai_normalisasi' => 1.0]);
    NilaiWarga::factory()->create(['warga_id' => $warga2->id, 'kriteria_id' => $c4->id, 'nilai_normalisasi' => 1.0]);

    $response = $this->actingAs($user)->postJson('/clustering/silhouette/process');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'success',
        'results' => [
            '*' => [
                'k',
                'silhouette_score',
                'quality',
                'quality_class',
                'iterations',
                'duration',
            ]
        ],
        'optimal_k'
    ]);
    expect($response->json('success'))->toBeTrue();
});

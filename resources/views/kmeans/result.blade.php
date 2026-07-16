<x-app>
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Hasil Analisis Clustering K-Means</h6>
                    <p class="text-muted fs-13 mb-0">Rangkuman hasil kalkulasi, detail iterasi matematis, dan koefisien Silhouette Score</p>
                </div>
                <div class="d-flex gap-2 no-print">
                    <button onclick="window.print()" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1">
                        <i class="ri-file-pdf-line fs-14"></i> Ekspor PDF
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm flex-center gap-1">
                        <i class="ri-map-pin-line fs-14"></i> Lihat Peta Distribusi
                    </a>
                    <a href="{{ route('clustering.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                        Analisis Ulang
                    </a>
                </div>
            </div>

            <!-- Summary Cards Row -->
            <div class="row g-4 mb-4">
                <!-- Silhouette Card -->
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm bg-body-tertiary">
                        <div class="card-body">
                            <p class="text-muted mb-2 fs-13">Silhouette Coefficient</p>
                            <h2 class="mb-1 fw-bold text-primary font-monospace">{{ number_format($result['silhouette_score'], 4) }}</h2>
                            @php
                                $s = $result['silhouette_score'];
                                if ($s > 0.7) {
                                    $quality = 'Struktur Klaster Sangat Kuat';
                                    $desc = 'Pemisahan antar kelompok sangat jelas dan logis.';
                                    $progressColor = 'bg-success';
                                } elseif ($s > 0.5) {
                                    $quality = 'Struktur Klaster Sedang / Cukup';
                                    $desc = 'Pemisahan klaster sudah memadai untuk penentuan bantuan.';
                                    $progressColor = 'bg-info';
                                } elseif ($s > 0.25) {
                                    $quality = 'Struktur Klaster Lemah';
                                    $desc = 'Banyak data berada di perbatasan antar kelompok.';
                                    $progressColor = 'bg-warning';
                                } else {
                                    $quality = 'Struktur Klaster Sangat Lemah / Tidak Valid';
                                    $desc = 'Klaster tumpang tindih. Direkomendasikan mengubah bobot kriteria.';
                                    $progressColor = 'bg-danger';
                                }
                            @endphp
                            <div class="progress h-6px my-2" role="progressbar" aria-label="Silhouette score progress">
                                <div class="progress-bar {{ $progressColor }} rounded-pill" style="width: {{ max(0, min(100, ($s + 1) * 50)) }}%"></div>
                            </div>
                            <span class="fs-12 fw-semibold d-block text-body">{{ $quality }}</span>
                            <span class="fs-11 text-muted">{{ $desc }}</span>
                        </div>
                    </div>
                </div>

                <!-- Iterations Card -->
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm bg-body-tertiary">
                        <div class="card-body">
                            <p class="text-muted mb-2 fs-13">Total Iterasi Kalkulasi</p>
                            <h2 class="mb-1 fw-bold text-success font-monospace">{{ $result['iterations_count'] }}</h2>
                            <div class="progress h-6px my-2" role="progressbar">
                                <div class="progress-bar bg-success rounded-pill" style="width: 100%"></div>
                            </div>
                            <span class="fs-12 fw-semibold d-block text-body">Konvergensi Tercapai</span>
                            <span class="fs-11 text-muted">Pusat centroid stabil dan tidak ada warga yang berpindah klaster lagi.</span>
                        </div>
                    </div>
                </div>

                <!-- Total Data Card -->
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm bg-body-tertiary">
                        <div class="card-body">
                            <p class="text-muted mb-2 fs-13">Jumlah Klaster & Data Warga</p>
                            <h2 class="mb-1 fw-bold text-info font-monospace">K = {{ $result['k'] }} <span class="text-muted fs-18 fw-normal">/ {{ count($result['assignments']) }} Warga</span></h2>
                            <div class="progress h-6px my-2" role="progressbar">
                                <div class="progress-bar bg-info rounded-pill" style="width: 100%"></div>
                            </div>
                            <span class="fs-12 fw-semibold d-block text-body">Metode: K-Means (Euclidean Distance)</span>
                            <span class="fs-11 text-muted">Seluruh warga berhasil diidentifikasi tingkat kelayakan PKH-nya.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Iterations Step Stepper (Wizard) -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom p-3">
                    <h6 class="mb-0 fw-semibold"><i class="ri-footprint-line text-primary me-2"></i> Langkah Kalkulasi Iterasi Matematis (Step-by-Step)</h6>
                </div>
                <div class="card-body p-3">
                    <!-- Nav Tabs for Iterations -->
                    <ul class="nav nav-pills nav-light mb-3" id="iteration-tab" role="tablist">
                        @foreach($result['history'] as $hist)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link py-1 px-3 fw-medium rounded-pill fs-13 {{ $loop->last ? 'active' : '' }}" 
                                    id="iter-{{ $hist['iteration'] }}-tab" 
                                    data-bs-toggle="pill" 
                                    data-bs-target="#iter-{{ $hist['iteration'] }}-content" 
                                    type="button" 
                                    role="tab" 
                                    aria-selected="{{ $loop->last ? 'true' : 'false' }}">
                                    Iterasi {{ $hist['iteration'] }} {{ $loop->last ? '(Konvergen)' : '' }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="iteration-tabContent">
                        @foreach($result['history'] as $hist)
                            <div class="tab-pane fade {{ $loop->last ? 'show active' : '' }}" 
                                id="iter-{{ $hist['iteration'] }}-content" 
                                role="tabpanel" 
                                aria-labelledby="iter-{{ $hist['iteration'] }}-tab">
                                
                                <div class="row g-4">
                                    <!-- Centroid Info -->
                                    <div class="col-lg-12">
                                        <h6 class="fs-13 fw-semibold mb-2 text-primary">Koordinat Pusat Klaster (Centroid) Pada Iterasi Ini:</h6>
                                        <div class="row g-3">
                                            @foreach($hist['centroids'] as $cIndex => $coords)
                                                <div class="col-md-3 col-6">
                                                    <div class="border rounded p-2 bg-light">
                                                        <div class="fw-bold fs-12 text-secondary mb-1">Centroid {{ $cIndex + 1 }}</div>
                                                        <div class="font-monospace fs-11">
                                                            C1: {{ number_format($coords[0], 2) }} | 
                                                            C2: {{ number_format($coords[1], 2) }} <br>
                                                            C3: {{ number_format($coords[2], 2) }} | 
                                                            C4: {{ number_format($coords[3], 2) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Iteration Matrix Table -->
                                    <div class="col-lg-12">
                                        <h6 class="fs-13 fw-semibold mb-2 text-primary">Matriks Jarak Warga ke Centroid & Asosiasi Klaster:</h6>
                                        <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                                            <table class="table table-sm table-bordered align-middle text-nowrap mb-0 table-hover">
                                                <thead class="table-light sticky-top">
                                                    <tr>
                                                        <th class="text-center" style="width: 50px;">No</th>
                                                        <th>Nama Warga</th>
                                                        <th class="text-center">Profil (C1,C2,C3,C4)</th>
                                                        @foreach($hist['centroids'] as $cIndex => $dummy)
                                                            <th class="text-center font-monospace">Jarak C{{ $cIndex + 1 }}</th>
                                                        @endforeach
                                                        <th class="text-center" style="width: 150px;">Klaster Terdekat</th>
                                                        <th class="text-center">Jarak Terpilih</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $no = 1; @endphp
                                                    @foreach($hist['assignments'] as $assign)
                                                        <tr>
                                                            <td class="text-center">{{ $no++ }}</td>
                                                            <td><span class="fw-semibold text-body">{{ $assign['warga_nama'] }}</span></td>
                                                            <td class="text-center font-monospace fs-11">
                                                                [{{ implode(',', $assign['values']) }}]
                                                            </td>
                                                            @foreach($assign['distances'] as $distIndex => $distVal)
                                                                <td class="text-center font-monospace fs-11">
                                                                    {{ number_format($distVal, 4) }}
                                                                </td>
                                                            @endforeach
                                                            <td class="text-center">
                                                                @php
                                                                    $colorMap = [0 => '#f43f5e', 1 => '#10b981', 2 => '#3b82f6', 3 => '#f59e0b', 4 => '#8b5cf6'];
                                                                    $color = $colorMap[$assign['cluster']] ?? '#6366f1';
                                                                @endphp
                                                                <span class="badge text-white font-semibold px-2 py-1" style="background-color: {{ $color }}">
                                                                    Klaster {{ $assign['cluster'] + 1 }}
                                                                </span>
                                                            </td>
                                                            <td class="text-center font-monospace fs-11 fw-bold">{{ number_format($assign['distance'], 4) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Final Cluster Assignments Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom p-3">
                    <h6 class="mb-0 fw-semibold"><i class="ri-award-line text-success me-2"></i> Hasil Akhir Pengelompokan & Kelayakan PKH</h6>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3" style="width: 50px;">No</th>
                                    <th>Nama Warga</th>
                                    <th class="text-center">Skor Normalisasi (C1,C2,C3,C4)</th>
                                    <th class="text-center">Jarak ke Centroid Terpilih</th>
                                    <th class="text-center" style="width: 250px;">Rekomendasi Status PKH</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $noFinal = 1; @endphp
                                @foreach($result['assignments'] as $assign)
                                    <tr>
                                        <td class="ps-3">{{ $noFinal++ }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar size-8 bg-light rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                                    {{ strtoupper(substr($assign['warga_nama'], 0, 1)) }}
                                                </div>
                                                <span class="fw-semibold">{{ $assign['warga_nama'] }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center font-monospace fs-12">
                                            C1: <strong>{{ $assign['values'][0] }}</strong> | 
                                            C2: <strong>{{ $assign['values'][1] }}</strong> | 
                                            C3: <strong>{{ $assign['values'][2] }}</strong> | 
                                            C4: <strong>{{ $assign['values'][3] }}</strong>
                                        </td>
                                        <td class="text-center font-monospace fs-12 text-muted">
                                            {{ number_format($assign['distance'], 4) }}
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $colorMap = [0 => '#f43f5e', 1 => '#10b981', 2 => '#3b82f6', 3 => '#f59e0b', 4 => '#8b5cf6'];
                                                $color = $colorMap[$assign['cluster']] ?? '#6366f1';
                                                
                                                // Tentukan label rekomendasi secara logis
                                                $label = "Klaster " . ($assign['cluster'] + 1);
                                                if ($result['k'] == 2) {
                                                    $label = $assign['cluster'] == 0 ? "LAYAK MENERIMA PKH" : "TIDAK LAYAK MENERIMA";
                                                } elseif ($result['k'] == 3) {
                                                    if ($assign['cluster'] == 0) $label = "SANGAT MEMBUTUHKAN";
                                                    elseif ($assign['cluster'] == 1) $label = "MEMBUTUHKAN";
                                                    else $label = "BANYAK TANGGUNGAN";
                                                }
                                            @endphp
                                            <span class="badge text-white px-3 py-1.5 fs-11 w-100" style="background-color: {{ $color }}">
                                                {{ $label }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('style')
    <style>
        @media print {
            .main-sidebar,
            header,
            .header,
            #sidebar-backdrop,
            .no-print,
            .btn,
            .nav-pills {
                display: none !important;
            }
            body {
                background-color: #fff !important;
                color: #000 !important;
                padding-left: 0 !important;
                margin-left: 0 !important;
            }
            .page-wrapper {
                margin-left: 0 !important;
                padding-left: 0 !important;
                padding-top: 0 !important;
            }
            .container-fluid {
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
            .table-responsive {
                overflow: visible !important;
                max-height: none !important;
            }
            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            tr {
                page-break-inside: avoid !important;
            }
        }
    </style>
    @endpush
</x-app>

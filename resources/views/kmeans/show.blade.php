<x-app>
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Rincian Hasil Clustering (Run #{{ $run->id }})</h6>
                    <p class="text-muted fs-13 mb-0">Rincian penempatan klaster warga Desa Campor Barat pada eksekusi tanggal {{ $run->run_date->format('d M Y - H:i') }}</p>
                </div>
                <div class="d-flex gap-2 no-print">
                    <button onclick="window.print()" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1">
                        <i class="ri-file-pdf-line fs-14"></i> Ekspor PDF
                    </button>
                    <a href="{{ route('clustering.history') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                        <i class="ri-arrow-left-line fs-14"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Summary Cards Row -->
            <div class="row g-4 mb-4">
                <!-- Silhouette Score -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-body-tertiary">
                        <div class="card-body">
                            <p class="text-muted mb-1 fs-13">Silhouette Score</p>
                            <h3 class="mb-0 fw-bold text-primary font-monospace">{{ number_format($run->silhouette_score, 4) }}</h3>
                            <span class="fs-12 text-muted">Kualitas klasterisasi</span>
                        </div>
                    </div>
                </div>

                <!-- Number of Clusters -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-body-tertiary">
                        <div class="card-body">
                            <p class="text-muted mb-1 fs-13">Jumlah Klaster (K)</p>
                            <h3 class="mb-0 fw-bold text-success font-monospace">K = {{ $run->k_value }}</h3>
                            <span class="fs-12 text-muted">Partisi kelompok yang terbentuk</span>
                        </div>
                    </div>
                </div>

                <!-- Data Count -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-body-tertiary">
                        <div class="card-body">
                            <p class="text-muted mb-1 fs-13">Jumlah Warga Dievaluasi</p>
                            <h3 class="mb-0 fw-bold text-info font-monospace">{{ $run->jumlah_data }} Warga</h3>
                            <span class="fs-12 text-muted">Total warga diikutsertakan</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom p-3">
                    <h6 class="mb-0 fw-semibold">Daftar Penempatan Klaster Warga</h6>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 text-nowrap table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3" style="width: 50px;">No</th>
                                    <th>Nama Warga</th>
                                    <th>NIK</th>
                                    <th>Alamat</th>
                                    <th class="text-center">Skor Normalisasi (C1,C2,C3,C4)</th>
                                    <th class="text-center">Jarak ke Centroid</th>
                                    <th class="text-center" style="width: 250px;">Rekomendasi Status PKH</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($hasil as $h)
                                    @php
                                        $w = $h->warga;
                                        $nilaiMapped = $w->nilaiWargas->keyBy('kriteria.kode');
                                        
                                        $c1 = isset($nilaiMapped['C1']) ? $nilaiMapped['C1']->nilai_normalisasi : 0;
                                        $c2 = isset($nilaiMapped['C2']) ? $nilaiMapped['C2']->nilai_normalisasi : 0;
                                        $c3 = isset($nilaiMapped['C3']) ? $nilaiMapped['C3']->nilai_normalisasi : 0;
                                        $c4 = isset($nilaiMapped['C4']) ? $nilaiMapped['C4']->nilai_normalisasi : 0;

                                        $colorMap = [0 => '#f43f5e', 1 => '#10b981', 2 => '#3b82f6', 3 => '#f59e0b', 4 => '#8b5cf6'];
                                        $color = $colorMap[$h->cluster_number] ?? '#6366f1';
                                        
                                        $label = "Klaster " . ($h->cluster_number + 1);
                                        if ($run->k_value == 2) {
                                            $label = $h->cluster_number == 0 ? "LAYAK MENERIMA PKH" : "TIDAK LAYAK MENERIMA";
                                        } elseif ($run->k_value == 3) {
                                            if ($h->cluster_number == 0) $label = "SANGAT MEMBUTUHKAN";
                                            elseif ($h->cluster_number == 1) $label = "MEMBUTUHKAN";
                                            else $label = "BANYAK TANGGUNGAN";
                                        }
                                    @endphp
                                    <tr>
                                        <td class="ps-3">{{ $no++ }}</td>
                                        <td>
                                            <div class="fw-semibold text-body">{{ $w->nama }}</div>
                                        </td>
                                        <td class="font-monospace fs-13">{{ $w->nik }}</td>
                                        <td><span class="text-muted fs-13">{{ $w->alamat }}</span></td>
                                        <td class="text-center font-monospace fs-12">
                                            [{{ $c1 }},{{ $c2 }},{{ $c3 }},{{ $c4 }}]
                                        </td>
                                        <td class="text-center font-monospace fs-12 text-muted">
                                            {{ number_format($h->jarak_centroid, 4) }}
                                        </td>
                                        <td class="text-center">
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
            .page-heading .d-flex {
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

<x-app>
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Evaluasi Nilai Kriteria Warga</h6>
                    <p class="text-muted fs-13 mb-0">Lihat perbandingan skor mentah (Raw) dan skor normalisasi (1-3) untuk seluruh warga</p>
                </div>
            </div>

            <!-- Success Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="ri-checkbox-circle-fill me-2 fs-18"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Table Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom p-3">
                    <h6 class="card-title mb-0 fw-semibold">Data Indikator Warga</h6>
                </div>

                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered table-hover align-middle mb-0 text-nowrap">
                            <thead class="table-light text-center">
                                <tr>
                                    <th rowspan="2" class="align-middle ps-3" style="width: 50px;">No</th>
                                    <th rowspan="2" class="align-middle">Nama Warga</th>
                                    <th colspan="2">C1 (Pendapatan)</th>
                                    <th colspan="2">C2 (Tanggungan)</th>
                                    <th colspan="2">C3 (Pendidikan)</th>
                                    <th colspan="2">C4 (Kondisi Rumah)</th>
                                    <th rowspan="2" class="align-middle pe-3" style="width: 100px;">Aksi</th>
                                </tr>
                                <tr>
                                    <th>Raw</th>
                                    <th>Norm</th>
                                    <th>Raw</th>
                                    <th>Norm</th>
                                    <th>Raw</th>
                                    <th>Norm</th>
                                    <th>Raw</th>
                                    <th>Norm</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wargas as $w)
                                    @php
                                        $nilaiMapped = $w->nilaiWargas->keyBy('kriteria.kode');
                                    @endphp
                                    <tr>
                                        <td class="text-center ps-3">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="fw-semibold text-body">{{ $w->nama }}</div>
                                            <small class="text-muted font-monospace">{{ $w->nik }}</small>
                                        </td>
                                        
                                        <!-- C1 -->
                                        <td class="font-monospace fs-13">
                                            {{ isset($nilaiMapped['C1']) ? 'Rp ' . number_format($nilaiMapped['C1']->nilai, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="text-center font-semibold">
                                            <span class="badge bg-primary-subtle text-primary fs-12">{{ isset($nilaiMapped['C1']) ? $nilaiMapped['C1']->nilai_normalisasi : '-' }}</span>
                                        </td>

                                        <!-- C2 -->
                                        <td class="text-center font-monospace fs-13">
                                            {{ isset($nilaiMapped['C2']) ? $nilaiMapped['C2']->nilai . ' org' : '-' }}
                                        </td>
                                        <td class="text-center font-semibold">
                                            <span class="badge bg-secondary-subtle text-secondary fs-12">{{ isset($nilaiMapped['C2']) ? $nilaiMapped['C2']->nilai_normalisasi : '-' }}</span>
                                        </td>

                                        <!-- C3 -->
                                        <td>
                                            @if(isset($nilaiMapped['C3']))
                                                @php
                                                    $edu = [0 => 'Tidak Sekolah', 1 => 'SD / Sederajat', 2 => 'SMP / Sederajat', 3 => 'SMA / Sederajat'];
                                                    echo $edu[$nilaiMapped['C3']->nilai] ?? $nilaiMapped['C3']->nilai;
                                                @endphp
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center font-semibold">
                                            <span class="badge bg-info-subtle text-info fs-12">{{ isset($nilaiMapped['C3']) ? $nilaiMapped['C3']->nilai_normalisasi : '-' }}</span>
                                        </td>

                                        <!-- C4 -->
                                        <td>
                                            @if(isset($nilaiMapped['C4']))
                                                @php
                                                    $house = [1 => 'Tidak Layak', 2 => 'Kurang Layak', 3 => 'Layak'];
                                                    echo $house[$nilaiMapped['C4']->nilai] ?? $nilaiMapped['C4']->nilai;
                                                @endphp
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center font-semibold">
                                            <span class="badge bg-warning-subtle text-warning fs-12">{{ isset($nilaiMapped['C4']) ? $nilaiMapped['C4']->nilai_normalisasi : '-' }}</span>
                                        </td>

                                        <td class="text-center pe-3">
                                            <a href="{{ route('nilai.edit', $w->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="ri-edit-2-line align-middle me-1"></i> Edit Skor
                                            </a>
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
        <link rel="stylesheet" href="{{ asset('assets/datatable-cdn/dataTables.bootstrap5.css') }}">
    @endpush

    @push('script')
        <script src="{{ asset('assets/datatable-cdn/jquery-3.7.1.js') }}"></script>
        <script src="{{ asset('assets/datatable-cdn/dataTables.js') }}"></script>
        <script src="{{ asset('assets/datatable-cdn/dataTables.bootstrap5.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#myTable').DataTable({
                });
            });
        </script>
    @endpush
</x-app>

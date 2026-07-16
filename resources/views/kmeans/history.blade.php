<x-app>
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Riwayat Analisis Clustering</h6>
                    <p class="text-muted fs-13 mb-0">Lihat riwayat dan rekaman eksekusi algoritma K-Means yang pernah dijalankan sebelumnya</p>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered align-middle mb-0 text-nowrap table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3" style="width: 50px;">No</th>
                                    <th>Tanggal Eksekusi</th>
                                    <th>Metode</th>
                                    <th class="text-center">Jumlah Klaster (K)</th>
                                    <th class="text-center">Jumlah Penduduk (N)</th>
                                    <th class="text-center">Silhouette Score</th>
                                    <th class="text-center">Status Kelayakan</th>
                                    <th class="text-end pe-3" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($runs as $run)
                                    <tr>
                                        <td class="ps-3">{{ $loop->iteration }}</td>
                                        <td data-order="{{ $run->run_date->timestamp }}">
                                            <div class="fw-semibold text-body">{{ $run->run_date->format('d M Y - H:i') }}</div>
                                            <small class="text-muted font-monospace">{{ $run->run_date->diffForHumans() }}</small>
                                        </td>
                                        <td><span class="badge bg-light text-dark border">{{ $run->metode }}</span></td>
                                        <td class="text-center font-bold text-primary fs-14">K = {{ $run->k_value }}</td>
                                        <td class="text-center font-monospace">{{ $run->jumlah_data }} warga</td>
                                        <td class="text-center font-monospace fw-bold text-success">{{ number_format($run->silhouette_score, 4) }}</td>
                                        <td class="text-center">
                                            @php
                                                $s = $run->silhouette_score;
                                                if ($s > 0.7) {
                                                    $label = 'Sangat Kuat';
                                                    $class = 'bg-success-subtle text-success';
                                                } elseif ($s > 0.5) {
                                                    $label = 'Sedang';
                                                    $class = 'bg-info-subtle text-info';
                                                } elseif ($s > 0.25) {
                                                    $label = 'Lemah';
                                                    $class = 'bg-warning-subtle text-warning';
                                                } else {
                                                    $label = 'Buruk';
                                                    $class = 'bg-danger-subtle text-danger';
                                                }
                                            @endphp
                                            <span class="badge {{ $class }} fs-11">{{ $label }}</span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="{{ route('clustering.show', $run->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="ri-eye-line align-middle me-1"></i> Lihat Hasil
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
                    "order": [[1, "desc"]]
                });
            });
        </script>
    @endpush
</x-app>

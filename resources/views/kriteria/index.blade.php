<x-app>
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Daftar Kriteria & Bobot Penilaian</h6>
                    <p class="text-muted fs-13 mb-0">Atur kriteria serta bobot persentase kepentingan untuk penentuan kelayakan PKH</p>
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

            <!-- Weight Total Warning -->
            @if(abs($totalBobot - 100) > 0.001)
                <div class="alert alert-warning border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="ri-error-warning-fill me-2 fs-18"></i>
                        <div><strong>Perhatian:</strong> Total bobot saat ini adalah <strong>{{ $totalBobot }}%</strong>. Disarankan agar total bobot kriteria berjumlah tepat <strong>100%</strong> untuk pembobotan normalisasi yang akurat.</div>
                    </div>
                </div>
            @endif

            <!-- Table Card -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table id="myTable" class="table table-bordered align-middle mb-0 text-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3" style="width: 80px;">Kode</th>
                                            <th>Nama Kriteria</th>
                                            <th>Bobot (%)</th>
                                            <th class="text-end pe-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kriterias as $k)
                                            <tr>
                                                <td class="ps-3"><span class="badge bg-secondary font-monospace fs-12">{{ $k->kode }}</span></td>
                                                <td><span class="fw-semibold">{{ $k->nama }}</span></td>
                                                <td class="font-monospace fw-bold fs-14">{{ $k->bobot }} %</td>
                                                <td class="text-end pe-3">
                                                    <a href="{{ route('kriteria.edit', $k->id) }}" class="btn btn-sm btn-outline-info">
                                                        <i class="ri-edit-line align-middle me-1"></i> Edit Bobot
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-light fw-bold">
                                            <td colspan="2" class="text-end ps-3">Total Bobot:</td>
                                            <td class="font-monospace fs-14 text-primary" colspan="2">{{ $totalBobot }} %</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
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
                    "paging": false,
                    "searching": false,
                    "info": false,
                    "ordering": false
                });
            });
        </script>
    @endpush
</x-app>

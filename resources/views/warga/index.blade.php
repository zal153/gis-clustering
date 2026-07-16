<x-app>
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div
                class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Daftar Data Penduduk (Warga)</h6>
                    <p class="text-muted fs-13 mb-0">Kelola informasi kependudukan dan koordinat rumah calon penerima PKH
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('warga.create') }}" class="btn btn-primary btn-sm flex-center gap-1">
                        <i class="ri-user-add-line fs-14"></i> Tambah Warga
                    </a>
                </div>
            </div>

            <!-- Success Alert -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="ri-checkbox-circle-fill me-2 fs-18"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Table Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Data Warga</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered align-middle text-nowrap">
                            <thead>
                                <tr class="bg-light">
                                    <th style="width: 50px;">No</th>
                                    <th>NIK</th>
                                    <th>Nama Warga</th>
                                    <th>Dusun</th>
                                    <th>Pekerjaan</th>
                                    <th>Koordinat (Lat, Lng)</th>
                                    <th>Kriteria (Raw)</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wargas as $w)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="font-monospace fw-medium">{{ $w->nik }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div
                                                    class="avatar size-8 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                                    {{ strtoupper(substr($w->nama, 0, 1)) }}
                                                </div>
                                                <span class="fw-semibold">{{ $w->nama }}</span>
                                            </div>
                                        </td>
                                        <td><span
                                                class="badge bg-secondary-subtle text-secondary">{{ $w->dusun ?? '-' }}</span>
                                        </td>
                                        <td><span class="text-muted fs-13">{{ $w->pekerjaan ?? '-' }}</span></td>
                                        <td class="font-monospace fs-12">
                                            <span class="text-info">{{ number_format($w->latitude, 6) }}</span>,
                                            <span class="text-success">{{ number_format($w->longitude, 6) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach ($w->getFormattedNilaiWargas() as $nilai)
                                                    <span class="badge bg-light text-dark border font-monospace fs-11"
                                                        title="{{ $nilai['nama'] }}">
                                                        {{ $nilai['kode'] }}: {{ $nilai['nilai'] }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="{{ route('warga.edit', $w->id) }}"
                                                    class="btn btn-sm btn-icon btn-outline-info"
                                                    title="Edit Profil & Nilai">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <form action="{{ route('warga.destroy', $w->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini? Semua nilai kriteria & hasil clustering warga ini akan dihapus.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-icon btn-outline-danger" title="Hapus">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
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
            $(document).ready(function() {
                $('#myTable').DataTable({});
            });
        </script>
    @endpush

</x-app>

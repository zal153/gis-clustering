<x-app>
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Daftar Pengguna Sistem (Operator)</h6>
                    <p class="text-muted fs-13 mb-0">Kelola akun admin/operator yang memiliki hak akses masuk ke sistem</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm flex-center gap-1">
                        <i class="ri-user-add-line fs-14"></i> Tambah Pengguna
                    </a>
                </div>
            </div>

            <!-- Messages Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="ri-checkbox-circle-fill me-2 fs-18"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="ri-error-warning-fill me-2 fs-18"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Table Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom p-3">
                    <h6 class="card-title mb-0 fw-semibold">Data Pengguna</h6>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered table-hover align-middle mb-0 text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Nama Pengguna</th>
                                    <th>Alamat Email</th>
                                    <th>Terdaftar Pada</th>
                                    <th class="text-end" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar size-8 bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <span class="fw-semibold d-block text-body">{{ $user->name }}</span>
                                                    @if(auth()->id() === $user->id)
                                                        <span class="badge bg-success-subtle text-success fs-10">Aktif (Anda)</span>
                                                    @endif
                                                    @if($user->email === 'admin@gmail.com')
                                                        <span class="badge bg-primary-subtle text-primary fs-10">Admin Utama</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="font-monospace fs-13">{{ $user->email }}</td>
                                        <td class="text-muted fs-13">{{ $user->created_at->format('d M Y, H:i') }}</td>
                                        <td class="text-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-icon btn-outline-info" title="Edit Pengguna">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                @if(auth()->id() !== $user->id && $user->email !== 'admin@gmail.com')
                                                     <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                         @csrf
                                                         @method('DELETE')
                                                         <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Hapus">
                                                             <i class="ri-delete-bin-line"></i>
                                                         </button>
                                                     </form>
                                                 @endif
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
            $(document).ready(function () {
                $('#myTable').DataTable({
                });
            });
        </script>
    @endpush
</x-app>

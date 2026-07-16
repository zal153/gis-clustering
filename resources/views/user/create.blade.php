<x-app>
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Tambah Pengguna Baru</h6>
                    <p class="text-muted fs-13 mb-0">Tambahkan akun admin/operator baru untuk mengakses sistem ini</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('user.index') }}" class="btn btn-outline-secondary btn-sm flex-center gap-1">
                        <i class="ri-arrow-left-line"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Form Card -->
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-bottom p-3">
                            <h6 class="card-title mb-0 fw-semibold">Form Tambah Pengguna</h6>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('user.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan alamat email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kata Sandi</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Buat kata sandi minimal 8 karakter" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Konfirmasi Kata Sandi</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required>
                                </div>

                                <div class="border-top pt-3 d-flex justify-content-end gap-2">
                                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                    <button type="submit" class="btn btn-primary px-4">Simpan Pengguna</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>

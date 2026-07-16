<x-app>
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Manajemen Profil Saya</h6>
                    <p class="text-muted fs-13 mb-0">Ubah informasi akun dan kata sandi Anda</p>
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

            <!-- Form Card -->
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-bottom p-3 d-flex align-items-center gap-2">
                            <div class="avatar size-9 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                <span class="fs-11 text-muted">{{ $user->email }}</span>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="Masukkan alamat email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="bg-light p-3 rounded mb-4 border">
                                    <h6 class="fs-13 fw-semibold text-primary mb-1">Ganti Kata Sandi</h6>
                                    <p class="text-muted fs-11 mb-3">Biarkan kosong jika Anda tidak ingin mengganti kata sandi saat ini.</p>

                                    <div class="mb-3">
                                        <label class="form-label fs-12 text-secondary">Kata Sandi Saat Ini</label>
                                        <input type="password" name="current_password" class="form-control bg-white @error('current_password') is-invalid @enderror" placeholder="Masukkan kata sandi lama">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fs-12 text-secondary">Kata Sandi Baru</label>
                                        <input type="password" name="password" class="form-control bg-white @error('password') is-invalid @enderror" placeholder="Kata sandi baru (min. 8 karakter)">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fs-12 text-secondary">Konfirmasi Kata Sandi Baru</label>
                                        <input type="password" name="password_confirmation" class="form-control bg-white" placeholder="Ulangi kata sandi baru">
                                    </div>
                                </div>

                                <div class="border-top pt-3 d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>

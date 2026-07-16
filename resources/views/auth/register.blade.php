<x-login>
    <div class="auth-wrapper position-relative container-fluid">
        <div class="row g-0 min-vh-100">
            <div class="col-12 col-xl-4 d-flex align-items-center justify-content-center bg-body-secondary">
                <div class="py-12 w-100">
                    <div class="row">
                        <div class="col-md-8 col-lg-6 col-xl-12 col-xxl-9 mx-auto">
                            <div class="mb-5 text-center text-xl-start">
                                <a href="{{ url('/') }}"
                                    class="logos d-inline-flex align-items-center gap-3 py-2.5 px-4 bg-white rounded-3 shadow-sm text-decoration-none">
                                    <!-- Ikon Vektor GeoPKH (Kombinasi Pin Maps & Klaster K-Means) -->
                                    <svg style="width: 42px; height: 42px; flex-shrink: 0;" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                        class="text-primary">
                                        <!-- Elemen 1: Pin Peta (Simbol GIS / Geografis) -->
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>

                                        <!-- Elemen 2: Tiga Node Terhubung di Dalam Pin (Simbol Keluarga / Klaster K-Means) -->
                                        <!-- Titik Pusat / Kepala Utama -->
                                        <circle cx="12" cy="9" r="1.5" fill="#10b981"></circle>
                                        <!-- Node Kiri -->
                                        <circle cx="9.5" cy="11.5" r="1" fill="#10b981"></circle>
                                        <!-- Node Kanan -->
                                        <circle cx="14.5" cy="11.5" r="1" fill="#10b981"></circle>
                                        <!-- Garis Penghubung antar Node Data -->
                                        <path d="M9.5 11.5 L12 9 L14.5 11.5" stroke="#34d399" stroke-width="1"
                                            opacity="0.8"></path>
                                    </svg>

                                    <!-- Teks Identitas Aplikasi -->
                                    <div class="d-flex flex-column text-start" style="line-height: 1.15;">
                                        <span class="fs-18 fw-extrabold tracking-tight text-dark"
                                            style="font-weight: 800; font-size: 20px !important;">
                                            Geo<span class="text-success" style="color: #10b981 !important;">PKH</span>
                                        </span>
                                        <span class="text-muted font-semibold tracking-wider uppercase"
                                            style="font-size: 9.5px; font-weight: 600;">
                                            Desa Campor Barat
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="card bg-transparent border-0 mb-0">
                                <div class="p-md-8 card-body">
                                    <h4 class="text-gradient fw-bold text-uppercase mb-2">Pendaftaran Akun</h4>
                                    <p class="text-muted mb-6">Silakan buat akun baru untuk mengakses panel operator.
                                    </p>

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                            <ul class="mb-0 ps-3">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <form action="{{ route('register') }}" method="POST">
                                        @csrf
                                        <div class="row g-5 mt-3">
                                            <div class="col-12 mt-0">
                                                <label for="nameInput" class="form-label">Nama Lengkap</label>
                                                <input type="text" name="name" id="nameInput"
                                                    placeholder="Masukkan nama lengkap"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    value="{{ old('name') }}" required autofocus>
                                            </div>
                                            <div class="col-12">
                                                <label for="emailInput" class="form-label">Alamat Email</label>
                                                <input type="email" name="email" id="emailInput"
                                                    placeholder="Masukkan email Anda"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email') }}" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="passwordInput" class="form-label">Kata Sandi</label>
                                                <div class="position-relative">
                                                    <input type="password" name="password" id="passwordInput"
                                                        class="form-control pe-8 @error('password') is-invalid @enderror"
                                                        placeholder="Buat kata sandi minimal 8 karakter" required>
                                                    <div class="position-absolute top-50 end-0 me-3 translate-middle-y text-muted cursor-pointer"
                                                        id="passwordShowIcon">
                                                        <i data-lucide="eye-off" class="size-5"></i>
                                                        <i data-lucide="eye" class="size-5 d-none"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="passwordConfirmInput" class="form-label">Konfirmasi Kata
                                                    Sandi</label>
                                                <div class="position-relative">
                                                    <input type="password" name="password_confirmation"
                                                        id="passwordConfirmInput" class="form-control pe-8"
                                                        placeholder="Ulangi kata sandi Anda" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary w-100 py-2.5">Daftar Akun
                                                    Baru</button>
                                            </div>
                                            <div class="col-12">
                                                <p class="text-center text-muted">Sudah memiliki akun? <a
                                                        href="{{ route('login') }}"
                                                        class="link link-primary fw-semibold">Masuk di Sini</a></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-8 my-auto d-none d-xl-block">
                <div class="py-12 px-4 px-lg-16 px-xxl-28 text-center text-xl-start">
                    <h2 class="mb-4 fw-bold">Pemetaan K-Means Clustering & SIG Penerima PKH</h2>
                    <p class="text-muted fs-lg mb-12">Sistem Informasi Geografis berbasis web untuk analisis kelayakan
                        calon penerima manfaat PKH Desa Campor Barat secara transparan, akurat, dan berbasis data
                        spasial.</p>
                    <div class="row g-4 g-md-6 justify-content-center justify-content-xl-start">
                        <div class="col-md-4">
                            <div class="card border-0 mb-0 shadow-sm">
                                <div class="card-body py-8 text-center">
                                    <img src="{{ asset('assets/bill-Cq_rnEWF.png') }}" alt="Penerima PKH"
                                        class="img-fluid size-12 mb-7 opacity-75">
                                    <h6 class="mb-0 fs-17 fw-semibold">Penerima PKH</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 mb-0 shadow-sm">
                                <div class="card-body py-8 text-center">
                                    <img src="{{ asset('assets/material-management-BykJPBQR.png') }}"
                                        alt="Algoritma K-Means" class="img-fluid size-12 mb-7 opacity-75">
                                    <h6 class="mb-0 fs-17 fw-semibold">K-Means Engine</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 mb-0 shadow-sm">
                                <div class="card-body py-8 text-center">
                                    <img src="{{ asset('assets/report-ByGbq5p9.png') }}" alt="Visualisasi Peta"
                                        class="img-fluid size-12 mb-7 opacity-75">
                                    <h6 class="mb-0 fs-17 fw-semibold">Visualisasi Peta</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{ asset('assets/asa-BLC_yXq6.jpg') }}" alt="Aksen"
            class="position-absolute top-0 end-0 h-100 w-28 object-fit-cover d-none d-xl-block">
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var passwordInput = document.getElementById('passwordInput');
            var passwordShowIcon = document.getElementById('passwordShowIcon');

            if (passwordShowIcon && passwordInput) {
                passwordShowIcon.addEventListener('click', function() {
                    var eyeOffIcon = passwordShowIcon.querySelector('[data-lucide="eye-off"]');
                    var eyeIcon = passwordShowIcon.querySelector('[data-lucide="eye"]');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        if (eyeOffIcon) eyeOffIcon.classList.add('d-none');
                        if (eyeIcon) eyeIcon.classList.remove('d-none');
                    } else {
                        passwordInput.type = 'password';
                        if (eyeOffIcon) eyeOffIcon.classList.remove('d-none');
                        if (eyeIcon) eyeIcon.classList.add('d-none');
                    }
                });
            }
        });
    </script>
    </body>

    </html>
</x-login>

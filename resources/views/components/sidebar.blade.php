<div id="main-sidebar" class="main-sidebar">
    <div class="sidebar-wrapper">
        <a href="#!" class="navbar-brand py-2">
            <div class="logo-lg">
                <div class="d-flex align-items-center gap-2 py-2 px-3 bg-white rounded-3 shadow-sm" style="display: flex !important;">
                    <!-- Ikon Vektor GeoPKH (Kombinasi Pin Maps & Klaster K-Means) -->
                    <svg style="width: 32px; height: 32px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="text-primary">
                        <!-- Elemen 1: Pin Peta (Simbol GIS / Geografis) -->
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        
                        <!-- Elemen 2: Tiga Node Terhubung di Dalam Pin (Simbol Keluarga / Klaster K-Means) -->
                        <!-- Titik Pusat / Kepala Utama -->
                        <circle cx="12" cy="9" r="1.5" fill="#10b981"></circle>
                        <!-- Node Kiri -->
                        <circle cx="9.5" cy="11.5" r="1" fill="#10b981"></circle>
                        <!-- Node Kanan -->
                        <circle cx="14.5" cy="11.5" r="1" fill="#10b981"></circle>
                        <!-- Garis Penghubung antar Node Data -->
                        <path d="M9.5 11.5 L12 9 L14.5 11.5" stroke="#34d399" stroke-width="1" opacity="0.8"></path>
                    </svg>

                    <!-- Teks Identitas Aplikasi -->
                    <div class="d-flex flex-column text-start" style="line-height: 1.1;">
                        <span class="fs-15 fw-extrabold tracking-tight text-dark" style="font-weight: 800;">
                            Geo<span class="text-success" style="color: #10b981 !important;">PKH</span>
                        </span>
                        <span class="text-muted font-semibold tracking-wider uppercase" style="font-size: 8px;">
                            Desa Campor Barat
                        </span>
                    </div>
                </div>
            </div>
            <div class="logo-sm">
                <div class="d-flex align-items-center justify-content-center bg-white p-1 rounded-circle shadow-sm" style="width: 32px; height: 32px; margin: auto; display: flex !important;">
                    <svg style="width: 24px; height: 24px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="text-primary">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <circle cx="12" cy="9" r="1.5" fill="#10b981"></circle>
                        <circle cx="9.5" cy="11.5" r="1" fill="#10b981"></circle>
                        <circle cx="14.5" cy="11.5" r="1" fill="#10b981"></circle>
                        <path d="M9.5 11.5 L12 9 L14.5 11.5" stroke="#34d399" stroke-width="1" opacity="0.8"></path>
                    </svg>
                </div>
            </div>
        </a>
        <div class="dropdown profile-dropdown">
            <a href="#!" class="btn d-flex align-items-center w-100 gap-2 px-4 py-3 text-start"
                data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar size-10 bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center fw-bold fs-14 flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-grow-1 content">
                    <h6 class="fw-medium text-truncate mb-0 text-body">{{ auth()->user()->name ?? 'Guest' }}</h6>
                    <p class="fs-12 text-muted mb-0">ID: {{ auth()->id() ?? '-' }}</p>
                </div>
                <div class="arrow">
                    <i data-lucide="chevron-down" class="size-4 text-body"></i>
                </div>
            </a>
            <div class="dropdown-menu w-64 profile-dropdown-menu p-0">
                <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom">
                    <div class="avatar size-9 bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center fw-bold fs-14 flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h6 class="mb-0 text-truncate">{{ auth()->user()->name ?? 'Guest' }}</h6>
                        <p class="mb-0 text-truncate">
                            <span class="fs-sm text-muted">{{ auth()->user()->email ?? '-' }}</span>
                        </p>
                    </div>
                </div>
                <div class="px-4 py-3">
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a class="profile-link rounded text-reset d-flex align-items-center" href="{{ route('profile.edit') }}">
                                <i class="ri-user-line me-2 text-muted fs-14"></i> Profil Saya
                            </a>
                        </li>
                        <li class="mt-2 pt-2 border-top">
                            <form action="{{ route('logout') }}" method="POST" id="logout-form-sidebar" class="d-none">
                                @csrf
                            </form>
                            <a class="profile-link rounded text-danger d-flex align-items-center" href="#!" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                                <i class="ri-logout-box-line me-2 fs-14"></i> Keluar / Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="navbar-menu px-5" id="navbar-menu-list" data-simplebar>
            <ul class="list-unstyled navbar-nav-menu mb-0">
                <li class="nav-menu-title">Navigasi Utama</li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <span class="icons"><i class="ri-map-pin-line"></i></span>
                        <span class="content">Peta Distribusi (SIG)</span>
                    </a>
                </li>

                <li class="nav-menu-title">Data Master</li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('warga*') ? 'active' : '' }}" href="{{ route('warga.index') }}">
                        <span class="icons"><i class="ri-user-line"></i></span>
                        <span class="content">Data Warga</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kriteria*') ? 'active' : '' }}"
                        href="{{ route('kriteria.index') }}">
                        <span class="icons"><i class="ri-settings-4-line"></i></span>
                        <span class="content">Kriteria & Bobot</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('nilai*') ? 'active' : '' }}"
                        href="{{ route('nilai.index') }}">
                        <span class="icons"><i class="ri-edit-line"></i></span>
                        <span class="content">Nilai Kriteria Warga</span>
                    </a>
                </li>

                <li class="nav-menu-title">Proses & Analisis</li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('clustering.index') || request()->routeIs('clustering.run') ? 'active' : '' }}"
                        href="{{ route('clustering.index') }}">
                        <span class="icons"><i class="ri-bubble-chart-line"></i></span>
                        <span class="content">Proses K-Means</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('clustering.history') || request()->routeIs('clustering.show') ? 'active' : '' }}"
                        href="{{ route('clustering.history') }}">
                        <span class="icons"><i class="ri-history-line"></i></span>
                        <span class="content">Riwayat Analisis</span>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('clustering.silhouette') ? 'active' : '' }}"
                        href="{{ route('clustering.silhouette') }}">
                        <span class="icons"><i class="ri-bar-chart-box-line"></i></span>
                        <span class="content">Pengujian Silhouette</span>
                    </a>
                </li> --}}

                <li class="nav-menu-title">Administrasi</li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('user*') ? 'active' : '' }}"
                        href="{{ route('user.index') }}">
                        <span class="icons"><i class="ri-user-settings-line"></i></span>
                        <span class="content">Kelola Pengguna</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

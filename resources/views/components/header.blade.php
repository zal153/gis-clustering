<header class="main-topbar" id="main-topbar">
    <div class="navbar-brand gap-2">
        <div class="logos">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none" aria-label="Topbar Logo">
                <!-- Ikon Vektor GeoPKH (Kombinasi Pin Maps & Klaster K-Means) -->
                <svg style="width: 28px; height: 28px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="text-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <circle cx="12" cy="9" r="1.5" fill="#10b981"></circle>
                    <circle cx="9.5" cy="11.5" r="1" fill="#10b981"></circle>
                    <circle cx="14.5" cy="11.5" r="1" fill="#10b981"></circle>
                    <path d="M9.5 11.5 L12 9 L14.5 11.5" stroke="#34d399" stroke-width="1" opacity="0.8"></path>
                </svg>
                <span class="fs-15 fw-extrabold tracking-tight text-dark" style="font-weight: 800; line-height: 1;">
                    Geo<span class="text-success" style="color: #10b981 !important;">PKH</span>
                </span>
            </a>
        </div>
        <button type="button" id="toggleSidebar" class="sidebar-toggle btn p-0" aria-label="sidebar-toggle">
            <i class="ri-layout-left-line fs-17"></i>
        </button>
    </div>
    <div class="d-flex align-items-center gap-3 ms-auto">
        <!-- Dark Mode Button -->
        <button type="button" id="darkModeButton" class="topbar-link topbar-mode btn nav-link collapsed-mode" aria-label="Theme Mode">
            <i data-lucide="moon" class="size-4 dark"></i>
            <i data-lucide="sun" class="size-4 light"></i>
        </button>
        <!-- Profile Dropdown -->
        <div class="dropdown profile-dropdown">
            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar size-8 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-12">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </button>
            <div class="dropdown-menu w-64 profile-dropdown-menu p-0">
                <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom">
                    <div class="avatar size-9 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-13 flex-shrink-0">
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
                            <form action="{{ route('logout') }}" method="POST" id="logout-form-header" class="d-none">
                                @csrf
                            </form>
                            <a class="profile-link rounded text-danger d-flex align-items-center" href="#!" onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
                                <i class="ri-logout-box-line me-2 fs-14"></i> Keluar / Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

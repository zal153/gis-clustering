<x-app>
    <!-- Leaflet.js Assets -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        #map {
            height: 550px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            z-index: 1;
        }
        .pulse-marker {
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            animation: pulse-animation 2s infinite;
        }
        @keyframes pulse-animation {
            0% {
                box-shadow: 0 0 0 0px var(--pulse-color, rgba(99, 102, 241, 0.7));
            }
            70% {
                box-shadow: 0 0 0 10px var(--pulse-color, rgba(99, 102, 241, 0));
            }
            100% {
                box-shadow: 0 0 0 0px var(--pulse-color, rgba(99, 102, 241, 0));
            }
        }
        .map-legend {
            background: rgba(255, 255, 255, 0.95);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            font-size: 13px;
            line-height: 1.5;
            color: #333;
            border: 1px solid rgba(0,0,0,0.1);
        }
        [data-bs-theme="dark"] .map-legend {
            background: rgba(30, 41, 59, 0.95) !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
        }
        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
            vertical-align: middle;
        }
        .warga-popup-table th, .warga-popup-table td {
            padding: 4px 8px;
            font-size: 12px;
        }
    </style>

    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="gap-2 page-heading mb-3 flex-column flex-md-row d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="mb-0">Peta Distribusi Kelayakan PKH</h6>
                    <p class="text-muted fs-13 mb-0">Pemetaan geografis warga Desa Campor Barat berdasarkan hasil K-Means Clustering</p>
                </div>
                <ul class="breadcrumb flex-shrink-0 mb-0">
                    <li class="breadcrumb-item"><a href="#!">Sistem Informasi Geografis</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>

            <!-- Stats Row -->
            <div class="row g-4 mb-4">
                <!-- Total Warga -->
                <div class="col-xl-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm bg-body-tertiary">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fs-13">Total Penduduk (Warga)</p>
                                <h3 class="mb-0 fw-bold">{{ $totalWarga }}</h3>
                                <span class="fs-12 text-muted">Terdaftar di Desa Campor Barat</span>
                            </div>
                            <div class="rounded-3 size-12 avatar bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center">
                                <i class="ri-user-line fs-20"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Kriteria -->
                <div class="col-xl-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm bg-body-tertiary">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fs-13">Jumlah Kriteria PKH</p>
                                <h3 class="mb-0 fw-bold">{{ $totalKriteria }}</h3>
                                <span class="fs-12 text-muted">C1 (Pendapatan) s/d C4 (Rumah)</span>
                            </div>
                            <div class="rounded-3 size-12 avatar bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center">
                                <i class="ri-settings-4-line fs-20"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- K-Value & Silhouette -->
                <div class="col-xl-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm bg-body-tertiary">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fs-13">Silhouette Score Terakhir</p>
                                <h3 class="mb-0 fw-bold">
                                    {{ $latestRun ? number_format($latestRun->silhouette_score, 4) : '-' }}
                                </h3>
                                @if($latestRun)
                                    @php
                                        $s = $latestRun->silhouette_score;
                                        if ($s > 0.7) {
                                            $quality = 'Sangat Kuat';
                                            $badgeClass = 'bg-success-subtle text-success';
                                        } elseif ($s > 0.5) {
                                            $quality = 'Sedang';
                                            $badgeClass = 'bg-info-subtle text-info';
                                        } elseif ($s > 0.25) {
                                            $quality = 'Lemah';
                                            $badgeClass = 'bg-warning-subtle text-warning';
                                        } else {
                                            $quality = 'Sangat Lemah / Tidak Valid';
                                            $badgeClass = 'bg-danger-subtle text-danger';
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }} fs-11 mt-1">Struktur: {{ $quality }}</span>
                                @else
                                    <span class="fs-12 text-muted">Belum ada analisis dijalankan</span>
                                @endif
                            </div>
                            <div class="rounded-3 size-12 avatar bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center">
                                <i class="ri-bubble-chart-line fs-20"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest Execution Status -->
                <div class="col-xl-3 col-md-6">
                    <div class="card h-100 border-0 shadow-sm bg-body-tertiary">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2 fs-13">Jumlah Klaster (K)</p>
                                <h3 class="mb-0 fw-bold">{{ $latestRun ? 'K = ' . $latestRun->k_value : 'N/A' }}</h3>
                                <span class="fs-12 text-muted">
                                    {{ $latestRun ? 'Analisis: ' . $latestRun->run_date->diffForHumans() : 'Silahkan jalankan analisis' }}
                                </span>
                            </div>
                            <div class="rounded-3 size-12 avatar bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center">
                                <i class="ri-history-line fs-20"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map View and Sidebar -->
            <div class="row g-4">
                <!-- Map Container -->
                <div class="col-lg-9">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between p-3 pb-0">
                            <h6 class="mb-0">Peta Spasial Desa Campor Barat</h6>
                            <div class="d-flex gap-2">
                                <button onclick="recenterMap()" class="btn btn-sm btn-outline-secondary px-3">
                                    <i class="ri-focus-3-line align-middle"></i> Fokus Desa
                                </button>
                                <a href="{{ route('clustering.index') }}" class="btn btn-sm btn-primary px-3">
                                    <i class="ri-play-line align-middle"></i> Analisis Baru
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>

                <!-- Analysis Panel -->
                <div class="col-lg-3">
                    <!-- Legend & Summary -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-transparent border-bottom p-3">
                            <h6 class="mb-0 fw-semibold">Informasi Klaster</h6>
                        </div>
                        <div class="card-body p-3">
                            @if($latestRun)
                                <div class="mb-4">
                                    <h6 class="fs-13 fw-medium mb-2">Pecahan Klaster Terakhir:</h6>
                                    @foreach($clusterCounts as $cNum => $cCount)
                                        @php
                                            $percent = $totalWarga > 0 ? round(($cCount / $totalWarga) * 100, 1) : 0;
                                            // Asumsi: Klaster dengan rata-rata pendapatan terendah adalah prioritas.
                                            // Warna dinamis sesuai dengan cluster_number
                                            $colorMap = [
                                                0 => '#f43f5e', // Rose / Merah (Paling Vulnerable / Prioritas Utama)
                                                1 => '#10b981', // Emerald / Hijau (Mandiri / Tidak Layak PKH)
                                                2 => '#3b82f6', // Blue / Biru (Cukup Layak)
                                                3 => '#f59e0b', // Amber / Oranye
                                                4 => '#8b5cf6', // Purple
                                            ];
                                            $color = $colorMap[$cNum] ?? '#6366f1';
                                            $label = "Klaster " . ($cNum + 1);
                                            if ($latestRun->k_value == 2) {
                                                $label = $cNum == 0 ? "Layak Menerima PKH" : "Tidak Layak Menerima";
                                            } elseif ($latestRun->k_value == 3) {
                                                if ($cNum == 0) $label = "Sangat Membutuhkan";
                                                elseif ($cNum == 1) $label = "Membutuhkan";
                                                else $label = "Banyak Tanggungan";
                                            }
                                        @endphp
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="legend-color" style="background-color: {{ $color }}"></span>
                                                <span class="fs-13">{{ $label }}</span>
                                            </div>
                                            <span class="fw-bold fs-13">{{ $cCount }} warga ({{ $percent }}%)</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="bg-light p-3 rounded border fs-12 text-muted">
                                    <i class="ri-information-line me-1 text-primary"></i>
                                    Warga diposisikan berdasarkan koordinat GPS terdaftar. Marker akan berdenyut (glowing pulse) secara dinamis sesuai warna klasternya.
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="ri-radar-line fs-32 text-muted mb-2"></i>
                                    <p class="text-muted fs-13 mb-3">Belum ada hasil pengelompokan tersimpan. Jalankan K-Means untuk memetakan kelayakan warga.</p>
                                    <a href="{{ route('clustering.index') }}" class="btn btn-sm btn-primary">Mulai Analisis</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Navigation -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-bottom p-3">
                            <h6 class="mb-0 fw-semibold">Peta Navigasi Cepat</h6>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-group list-group-flush fs-13">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                    <a href="{{ route('warga.index') }}" class="text-reset"><i class="ri-user-line me-2 text-primary"></i> Kelola Data Warga</a>
                                    <i class="ri-arrow-right-s-line"></i>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                    <a href="{{ route('kriteria.index') }}" class="text-reset"><i class="ri-settings-4-line me-2 text-info"></i> Bobot Kriteria</a>
                                    <i class="ri-arrow-right-s-line"></i>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                    <a href="{{ route('nilai.index') }}" class="text-reset"><i class="ri-edit-line me-2 text-warning"></i> Nilai Indikator Penduduk</a>
                                    <i class="ri-arrow-right-s-line"></i>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                    <a href="{{ route('clustering.history') }}" class="text-reset"><i class="ri-history-line me-2 text-success"></i> Riwayat Clustering</a>
                                    <i class="ri-arrow-right-s-line"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Script -->
    <script>
        var map;
        var markers = [];

        document.addEventListener("DOMContentLoaded", function() {
            // Koordinat pusat Desa Campor Barat, Ambunten, Sumenep
            var centerLat = -6.889722;
            var centerLng = 113.756111;

            // Inisialisasi peta Leaflet
            map = L.map('map').setView([centerLat, centerLng], 14);

            // Tentukan style peta berdasarkan tema bootstrap
            var tileUrl = 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';
            
            // Check if dark mode is active
            var currentTheme = document.documentElement.getAttribute('data-bs-theme');
            if (currentTheme === 'dark') {
                tileUrl = 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png';
            }

            var defaultRoadMap = L.tileLayer(tileUrl, {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 20
            });

            var satelliteMap = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                attribution: '&copy; Google Maps',
                maxZoom: 20
            });

            // Tambahkan default layer ke peta
            defaultRoadMap.addTo(map);

            // Layer control untuk memilih Peta Standar vs Citra Satelit
            var baseMaps = {
                "Peta Standar": defaultRoadMap,
                "Citra Satelit": satelliteMap
            };
            L.control.layers(baseMaps, null, { position: 'topright' }).addTo(map);

            // Observasi perubahan tema dinamis untuk mengganti tile map standar
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'data-bs-theme') {
                        var newTheme = document.documentElement.getAttribute('data-bs-theme');
                        var newTileUrl = (newTheme === 'dark') 
                            ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
                            : 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';
                        defaultRoadMap.setUrl(newTileUrl);
                    }
                });
            });
            observer.observe(document.documentElement, { attributes: true });

            // Data warga yang dilempar dari controller PHP
            var wargas = @json($wargas);

            // Warna representatif per klaster
            var colorMap = {
                0: '#f43f5e', // Rose / Merah
                1: '#10b981', // Emerald / Hijau
                2: '#3b82f6', // Blue / Biru
                3: '#f59e0b', // Amber
                4: '#8b5cf6'  // Purple
            };

            // Tambahkan markers warga ke peta
            wargas.forEach(function(w) {
                if (w.latitude && w.longitude) {
                    var clusterColor = w.cluster !== null ? (colorMap[w.cluster] || '#6366f1') : '#6366f1';
                    
                    // Buat custom icon dengan pulse animation
                    var pulseIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div class="pulse-marker" style="background-color: ${clusterColor}; width: 14px; height: 14px; --pulse-color: ${hexToRgba(clusterColor, 0.7)}"></div>`,
                        iconSize: [14, 14],
                        iconAnchor: [7, 7]
                    });

                    // Siapkan content popup
                    var criteriaRows = '';
                    w.nilai.forEach(function(n) {
                        criteriaRows += `
                            <tr>
                                <td><strong>${n.kriteria_kode}</strong> (${n.kriteria_nama})</td>
                                <td>${formatValue(n.kriteria_kode, n.nilai)}</td>
                                <td class="text-end font-monospace"><span class="badge bg-secondary-subtle text-secondary">${n.nilai_normalisasi}</span></td>
                            </tr>
                        `;
                    });

                    var statusPKH = '<span class="badge bg-secondary">Belum Diklaster</span>';
                    if (w.cluster !== null) {
                        var label = "Klaster " + (w.cluster + 1);
                        var uniqueClusters = new Set(wargas.filter(x => x.cluster !== null).map(x => x.cluster));
                        var kVal = uniqueClusters.size;
                        if (kVal === 2) {
                            label = w.cluster === 0 ? "Layak Menerima PKH" : "Tidak Layak Menerima";
                        } else if (kVal === 3) {
                            if (w.cluster === 0) label = "Sangat Membutuhkan";
                            else if (w.cluster === 1) label = "Membutuhkan";
                            else if (w.cluster === 2) label = "Banyak Tanggungan";
                        }
                        statusPKH = `<span class="badge text-white" style="background-color: ${clusterColor}">${label}</span>`;
                    }

                    var popupContent = `
                        <div style="min-width: 250px;">
                            <div class="border-bottom pb-2 mb-2">
                                <h6 class="mb-0 fw-bold fs-14">${w.nama}</h6>
                                <small class="text-muted">NIK: ${w.nik}</small>
                            </div>
                            <p class="mb-2 fs-12"><strong>Alamat:</strong> ${w.alamat}</p>
                            <p class="mb-2 fs-12"><strong>Status Kelayakan:</strong> ${statusPKH}</p>
                            <table class="table table-sm table-borderless mb-0 warga-popup-table">
                                <thead>
                                    <tr class="border-bottom">
                                        <th class="ps-0">Kriteria</th>
                                        <th>Nilai Raw</th>
                                        <th class="text-end pe-0">Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${criteriaRows}
                                </tbody>
                            </table>
                        </div>
                    `;

                    var marker = L.marker([w.latitude, w.longitude], { icon: pulseIcon })
                        .bindPopup(popupContent)
                        .addTo(map);

                    markers.push(marker);
                }
            });

            // Auto fit bounds jika ada data marker
            if (markers.length > 0) {
                var group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        });

        function recenterMap() {
            if (map) {
                map.setView([-6.89500000, 113.78500000], 14);
            }
        }

        // Helper untuk format raw value
        function formatValue(kode, val) {
            if (kode === 'C1') {
                return 'Rp ' + parseInt(val).toLocaleString('id-ID');
            }
            if (kode === 'C3') {
                var eduMap = { 0: 'Tidak Sekolah', 1: 'SD', 2: 'SMP', 3: 'SMA' };
                return eduMap[val] || val;
            }
            if (kode === 'C4') {
                var houseMap = { 1: 'Tidak Layak', 2: 'Kurang Layak', 3: 'Layak' };
                return houseMap[val] || val;
            }
            return val;
        }

        // Helper hex to RGBA
        function hexToRgba(hex, alpha) {
            var r = parseInt(hex.slice(1, 3), 16),
                g = parseInt(hex.slice(3, 5), 16),
                b = parseInt(hex.slice(5, 7), 16);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }
    </script>
</x-app>

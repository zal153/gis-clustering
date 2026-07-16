<x-app>
    <!-- Leaflet.js Assets for Coordinate Picker -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        #picker-map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            border: 1px solid rgba(0,0,0,0.1);
            margin-bottom: 10px;
            z-index: 1;
        }
    </style>

    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Edit Data Penduduk (Warga)</h6>
                    <p class="text-muted fs-13 mb-0">Ubah informasi kependudukan, koordinat, dan nilai kriteria warga: {{ $warga->nama }}</p>
                </div>
                <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ri-arrow-left-line fs-14"></i> Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form action="{{ route('warga.update', $warga->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row g-4">
                                    <!-- Demographics Section -->
                                    <div class="col-md-6 border-end pe-md-4">
                                        <h5 class="card-title fs-15 border-bottom pb-2 mb-3"><i class="ri-profile-line me-2 text-primary"></i> Data Diri & Koordinat</h5>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                                            <input type="text" name="nik" value="{{ old('nik', $warga->nik) }}" class="form-control @error('nik') is-invalid @enderror" placeholder="Contoh: 3529012345670001" required>
                                            @error('nik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" name="nama" value="{{ old('nama', $warga->nama) }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Aidah" required>
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Dusun</label>
                                            <select name="dusun" class="form-select @error('dusun') is-invalid @enderror">
                                                <option value="">-- Pilih Dusun --</option>
                                                <option value="CAMPOR" {{ old('dusun', $warga->dusun) == 'CAMPOR' ? 'selected' : '' }}>CAMPOR</option>
                                                <option value="KOLPOH" {{ old('dusun', $warga->dusun) == 'KOLPOH' ? 'selected' : '' }}>KOLPOH</option>
                                                <option value="TANA MERA" {{ old('dusun', $warga->dusun) == 'TANA MERA' ? 'selected' : '' }}>TANA MERA</option>
                                            </select>
                                            @error('dusun')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Alamat Lengkap</label>
                                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2" placeholder="Contoh: Dusun Campor, Desa Campor Barat" required>{{ old('alamat', $warga->alamat) }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Pekerjaan</label>
                                            <select name="pekerjaan" class="form-select @error('pekerjaan') is-invalid @enderror">
                                                <option value="">-- Pilih Pekerjaan --</option>
                                                <option value="Petani" {{ old('pekerjaan', $warga->pekerjaan) == 'Petani' ? 'selected' : '' }}>Petani</option>
                                                <option value="Pedagang" {{ old('pekerjaan', $warga->pekerjaan) == 'Pedagang' ? 'selected' : '' }}>Pedagang</option>
                                                <option value="Buruh" {{ old('pekerjaan', $warga->pekerjaan) == 'Buruh' ? 'selected' : '' }}>Buruh</option>
                                                <option value="Nelayan" {{ old('pekerjaan', $warga->pekerjaan) == 'Nelayan' ? 'selected' : '' }}>Nelayan</option>
                                                <option value="Lainnya" {{ old('pekerjaan', $warga->pekerjaan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                            @error('pekerjaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label class="form-label">Latitude</label>
                                                <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $warga->latitude) }}" class="form-control @error('latitude') is-invalid @enderror" readonly required>
                                                @error('latitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label">Longitude</label>
                                                <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $warga->longitude) }}" class="form-control @error('longitude') is-invalid @enderror" readonly required>
                                                @error('longitude')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Pilih Lokasi di Peta (Klik / Geser Marker)</label>
                                            <div id="picker-map"></div>
                                            <span class="fs-12 text-muted"><i class="ri-information-line"></i> Klik pada peta untuk memindahkan marker ke koordinat rumah warga.</span>
                                        </div>
                                    </div>

                                    <!-- Criteria Section -->
                                    <div class="col-md-6 ps-md-4">
                                        <h5 class="card-title fs-15 border-bottom pb-2 mb-3"><i class="ri-list-check-line me-2 text-warning"></i> Nilai Kriteria PKH</h5>

                                        <!-- C1: Pendapatan -->
                                        <div class="mb-3">
                                            <label class="form-label">Pendapatan Bulanan (Rp) - [C1]</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" name="c1" value="{{ old('c1', isset($nilaiWarga['C1']) ? (int)$nilaiWarga['C1']->nilai : '') }}" class="form-control @error('c1') is-invalid @enderror" placeholder="Contoh: 500000" required>
                                            </div>
                                            <div class="fs-12 text-muted mt-1">
                                                Klasifikasi Normalisasi:<br>
                                                - &lt; Rp 300.000 (Skor 1)<br>
                                                - Rp 300.000 s/d Rp 600.000 (Skor 2)<br>
                                                - &gt; Rp 600.000 (Skor 3)
                                            </div>
                                            @error('c1')
                                                <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- C2: Tanggungan -->
                                        <div class="mb-3">
                                            <label class="form-label">Jumlah Tanggungan Keluarga (Orang) - [C2]</label>
                                            <input type="number" name="c2" value="{{ old('c2', isset($nilaiWarga['C2']) ? (int)$nilaiWarga['C2']->nilai : '') }}" class="form-control @error('c2') is-invalid @enderror" placeholder="Contoh: 3" required>
                                            <div class="fs-12 text-muted mt-1">Skor normalisasi bernilai langsung dari jumlah tanggungan.</div>
                                            @error('c2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- C3: Pendidikan -->
                                        <div class="mb-3">
                                            <label class="form-label">Pendidikan Terakhir Kepala Keluarga - [C3]</label>
                                            <select name="c3" class="form-select @error('c3') is-invalid @enderror" required>
                                                @php
                                                    $c3Val = old('c3', isset($nilaiWarga['C3']) ? (int)$nilaiWarga['C3']->nilai : '');
                                                @endphp
                                                <option value="" disabled>Pilih tingkat pendidikan...</option>
                                                <option value="0" {{ $c3Val === 0 ? 'selected' : '' }}>Tidak Sekolah / PAUD (Skor 0)</option>
                                                <option value="1" {{ $c3Val === 1 ? 'selected' : '' }}>SD / Sederajat (Skor 1)</option>
                                                <option value="2" {{ $c3Val === 2 ? 'selected' : '' }}>SMP / Sederajat (Skor 2)</option>
                                                <option value="3" {{ $c3Val === 3 ? 'selected' : '' }}>SMA / SMK / Sederajat (Skor 3)</option>
                                            </select>
                                            @error('c3')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- C4: Kondisi Rumah -->
                                        <div class="mb-3">
                                            <label class="form-label">Kondisi Rumah - [C4]</label>
                                            <select name="c4" class="form-select @error('c4') is-invalid @enderror" required>
                                                @php
                                                    $c4Val = old('c4', isset($nilaiWarga['C4']) ? (int)$nilaiWarga['C4']->nilai : '');
                                                @endphp
                                                <option value="" disabled>Pilih kondisi rumah...</option>
                                                <option value="1" {{ $c4Val === 1 ? 'selected' : '' }}>Tidak Layak Huni (Skor 1)</option>
                                                <option value="2" {{ $c4Val === 2 ? 'selected' : '' }}>Kurang Layak Huni (Skor 2)</option>
                                                <option value="3" {{ $c4Val === 3 ? 'selected' : '' }}>Layak Huni (Skor 3)</option>
                                            </select>
                                            @error('c4')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top pt-3 mt-4 d-flex justify-content-end gap-2">
                                    <button type="button" onclick="window.history.back()" class="btn btn-outline-secondary">Batal</button>
                                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Coordinate Picker Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var currentLat = {{ $warga->latitude ?? -6.889722 }};
            var currentLng = {{ $warga->longitude ?? 113.756111 }};

            // Inisialisasi peta picker
            var map = L.map('picker-map').setView([currentLat, currentLng], 14);

            var defaultRoadMap = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
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

            // Buat marker yang diposisikan di lokasi sekarang
            var marker = L.marker([currentLat, currentLng], {
                draggable: true
            }).addTo(map);

            // Update inputs saat marker digeser
            marker.on('dragend', function(e) {
                var position = marker.getLatLng();
                updateCoords(position.lat, position.lng);
            });

            // Update inputs & marker saat peta diklik
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateCoords(e.latlng.lat, e.latlng.lng);
            });

            function updateCoords(lat, lng) {
                document.getElementById('latitude').value = parseFloat(lat).toFixed(8);
                document.getElementById('longitude').value = parseFloat(lng).toFixed(8);
            }
        });
    </script>
</x-app>

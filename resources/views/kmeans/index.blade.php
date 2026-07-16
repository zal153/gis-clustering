<x-app>
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div
                class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Proses Clustering K-Means</h6>
                    <p class="text-muted fs-13 mb-0">Kelompokkan warga ke dalam klaster tingkat kelayakan bantuan sosial
                        PKH menggunakan algoritma K-Means</p>
                </div>
                <div>
                    <a href="{{ route('clustering.history') }}"
                        class="btn btn-outline-secondary btn-sm flex-center gap-1">
                        <i class="ri-history-line fs-14"></i> Riwayat Clustering
                    </a>
                </div>
            </div>

            <!-- Error Alert -->
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="ri-error-warning-fill me-2 fs-18"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Warning: data kurang -->
            @if ($totalWarga < 2)
                <div class="alert alert-warning border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-alert-line fs-18"></i>
                        <div>
                            Data warga masih kosong atau kurang dari 2.
                            <a href="{{ route('warga.create') }}" class="alert-link">Tambah data warga</a> terlebih
                            dahulu sebelum menjalankan clustering.
                        </div>
                    </div>
                </div>
            @endif

            <div class="row g-4">
                <!-- Parameters Panel -->
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-bottom p-3">
                            <h6 class="mb-0 fw-semibold">Parameter Analisis</h6>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('clustering.run') }}" method="POST" id="clusteringForm">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label fw-medium text-body fs-14">Jumlah Klaster (K)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ri-node-tree"></i></span>
                                        <select name="k" id="kSelect"
                                            class="form-select @error('k') is-invalid @enderror" required>
                                            <option value="2" selected>K = 2 (Layak &amp; Tidak Layak)</option>
                                            <option value="3">K = 3 (Tinggi, Sedang, Rendah tingkat kemiskinan)
                                            </option>
                                            <option value="4">K = 4 (Sangat Layak, Layak, Cukup Layak, Tidak Layak)
                                            </option>
                                            <option value="5">K = 5 (Lima tingkatan kelayakan)</option>
                                        </select>
                                    </div>
                                    @error('k')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                    @enderror

                                    <!-- Peringatan K > total warga -->
                                    <div id="kWarning" class="alert alert-warning py-2 px-3 fs-12 mt-2 mb-0 d-none"
                                        role="alert">
                                        <i class="ri-alert-line me-1"></i>
                                        Jumlah klaster (K) tidak boleh melebihi jumlah warga terdaftar
                                        (<strong>{{ $totalWarga }}</strong>).
                                    </div>

                                    <div class="fs-12 text-muted mt-2">
                                        * Catatan: Memilih nilai K akan membagi jumlah penduduk menjadi K kelompok
                                        secara otomatis berdasarkan kemiripan tingkat kesejahteraan (kondisi ekonomi).
                                    </div>
                                </div>

                                <!-- Dataset Info -->
                                <div class="p-3 bg-light rounded border mb-4">
                                    <h6 class="fs-13 fw-semibold mb-2">
                                        <i class="ri-database-2-line text-primary me-1"></i> Dataset Siap Proses
                                    </h6>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="text-center">
                                            <div class="fs-20 fw-bold text-primary">{{ $totalWarga }}</div>
                                            <div class="fs-11 text-muted">Total Warga</div>
                                        </div>
                                        <div class="vr"></div>
                                        <div class="fs-12 text-muted">
                                            Semua warga terdaftar beserta nilai kriteria (C1–C4) akan digunakan sebagai
                                            input algoritma K-Means.
                                        </div>
                                    </div>
                                </div>

                                <!-- Latest Run Info -->
                                @if ($latestRun)
                                    <div class="p-3 bg-light rounded border mb-4">
                                        <h6 class="fs-13 fw-semibold mb-2">
                                            <i class="ri-history-line text-secondary me-1"></i> Clustering Terakhir
                                        </h6>
                                        <div class="fs-12 text-muted">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>Tanggal</span>
                                                <span
                                                    class="text-body fw-medium">{{ $latestRun->run_date->format('d M Y, H:i') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>Nilai K</span>
                                                <span class="text-body fw-medium">{{ $latestRun->k_value }}
                                                    Klaster</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>Silhouette Score</span>
                                                <span
                                                    class="text-body fw-medium">{{ number_format($latestRun->silhouette_score, 4) }}</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('clustering.show', $latestRun->id) }}"
                                            class="btn btn-sm btn-outline-secondary w-100 mt-2">
                                            <i class="ri-eye-line me-1"></i> Lihat Hasil
                                        </a>
                                    </div>
                                @endif

                                <button type="submit" id="submitBtn" class="btn btn-primary w-100 flex-center gap-2"
                                    @if ($totalWarga < 2) disabled @endif>
                                    <span id="btnDefault" class="flex-center gap-2">
                                        <i class="ri-play-circle-line fs-18"></i> Jalankan Algoritma K-Means
                                    </span>
                                    <span id="btnLoading" class="flex-center gap-2 d-none">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Sedang memproses...
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            const totalWarga = {{ $totalWarga }};
            const kSelect = document.getElementById('kSelect');
            const kWarning = document.getElementById('kWarning');
            const submitBtn = document.getElementById('submitBtn');

            function checkK() {
                const k = parseInt(kSelect.value);
                if (k > totalWarga) {
                    kWarning.classList.remove('d-none');
                    submitBtn.disabled = true;
                } else {
                    kWarning.classList.add('d-none');
                    submitBtn.disabled = totalWarga < 2;
                }
            }

            kSelect.addEventListener('change', checkK);
            checkK();

            document.getElementById('clusteringForm').addEventListener('submit', function() {
                document.getElementById('btnDefault').classList.add('d-none');
                document.getElementById('btnLoading').classList.remove('d-none');
                submitBtn.disabled = true;
            });
        </script>
    @endpush
</x-app>

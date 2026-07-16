<x-app>
    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Pengujian Silhouette Score</h6>
                    <p class="text-muted fs-13 mb-0">Analisis perbandingan Silhouette Coefficient untuk mengidentifikasi jumlah klaster (K) optimal.</p>
                </div>
                <ul class="breadcrumb flex-shrink-0 mb-0">
                    <li class="breadcrumb-item"><a href="#!">Proses &amp; Analisis</a></li>
                    <li class="breadcrumb-item active">Pengujian Silhouette</li>
                </ul>
            </div>

            <!-- Theory explanation -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom p-3">
                    <h6 class="mb-0 fw-semibold"><i class="ri-information-line text-primary me-1"></i> Apa itu Silhouette Score?</h6>
                </div>
                <div class="card-body p-4 fs-13 text-muted">
                    <p class="mb-3">
                        <strong>Silhouette Score (Silhouette Coefficient)</strong> adalah metrik yang digunakan untuk mengevaluasi kualitas hasil clustering. Metrik ini mengukur seberapa dekat setiap data dengan anggotanya di klaster sendiri dibandingkan dengan jarak ke klaster tetangga terdekat. Nilai berkisar dari <strong>-1</strong> (klaster tidak valid) hingga <strong>+1</strong> (klaster terpisah sempurna).
                    </p>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="p-3 rounded border bg-light text-center">
                                <span class="badge bg-success-subtle text-success mb-1">s(i) > 0.70</span>
                                <div class="fw-bold text-dark fs-12">Struktur Kuat</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded border bg-light text-center">
                                <span class="badge bg-info-subtle text-info mb-1">0.51 - 0.70</span>
                                <div class="fw-bold text-dark fs-12">Struktur Sedang</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded border bg-light text-center">
                                <span class="badge bg-warning-subtle text-warning mb-1">0.26 - 0.50</span>
                                <div class="fw-bold text-dark fs-12">Struktur Lemah</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded border bg-light text-center">
                                <span class="badge bg-danger-subtle text-danger mb-1">≤ 0.25</span>
                                <div class="fw-bold text-dark fs-12">Struktur Sangat Lemah</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Action Panel -->
                <div class="col-lg-12" id="actionPanel">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="avatar size-16 bg-primary-subtle text-primary rounded-circle mx-auto mb-3 flex-center">
                                <i class="ri-bar-chart-box-line fs-28"></i>
                            </div>
                            <h5 class="fw-bold">Mulai Analisis Silhouette Score</h5>
                            <p class="text-muted mx-auto fs-13 mb-4" style="max-width: 500px;">
                                Sistem akan menghitung algoritma K-Means secara berurutan untuk nilai K=2, K=3, K=4, dan K=5 menggunakan dataset {{ $totalWarga }} warga terdaftar, kemudian membandingkan Silhouette Score untuk menemukan struktur klaster terbaik.
                            </p>
                            
                            <button type="button" id="startTestBtn" class="btn btn-primary px-5 py-2.5 flex-center gap-2 mx-auto" @if($totalWarga < 2) disabled @endif>
                                <span id="btnText"><i class="ri-play-circle-line fs-18"></i> Jalankan Pengujian Perbandingan</span>
                                <span id="btnSpin" class="d-none flex-center gap-2">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Mengevaluasi K=2 s/d K=5...
                                </span>
                            </button>

                            @if($totalWarga < 2)
                                <div class="alert alert-warning border-0 py-2 px-3 fs-12 mt-3 d-inline-block" role="alert">
                                    <i class="ri-alert-line me-1"></i> Data warga kurang dari 2. Tambahkan data terlebih dahulu.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Results Section (Hidden initially) -->
                <div class="col-lg-12 d-none" id="resultsSection">
                    <div class="row g-4">
                        <!-- Table results -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-transparent border-bottom p-3 d-flex align-items-center justify-content-between">
                                    <h6 class="mb-0 fw-semibold">Tabel Hasil Perbandingan K</h6>
                                    <button type="button" id="exportExcelBtn" class="btn btn-success btn-sm flex-center gap-1">
                                        <i class="ri-file-excel-2-line fs-14"></i> Ekspor ke Excel
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-center" style="width: 80px;">Nilai K</th>
                                                    <th class="text-end">Silhouette Score</th>
                                                    <th class="text-center">Kualitas Struktur</th>
                                                    <th class="text-center">Iterasi</th>
                                                    <th class="text-end">Waktu Proses</th>
                                                    <th class="text-center" style="width: 130px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="comparisonTableBody">
                                                <!-- Dynamic Rows -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart results -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-transparent border-bottom p-3">
                                    <h6 class="mb-0 fw-semibold">Grafik Silhouette Score vs Jumlah Klaster (K)</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div id="silhouetteChart" style="min-height: 280px;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Recommendation Recommendation Card -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm bg-primary bg-opacity-10" id="recommendationCard">
                                <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar size-14 bg-primary text-white rounded shadow flex-center flex-shrink-0">
                                            <i class="ri-lightbulb-line fs-24"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-1" id="recommendationTitle">Jumlah Klaster Optimal</h5>
                                            <p class="text-muted fs-13 mb-0" id="recommendationDesc"></p>
                                        </div>
                                    </div>
                                    <div>
                                        <form action="{{ route('clustering.run') }}" method="POST" id="optimalRunForm">
                                            @csrf
                                            <input type="hidden" name="k" id="optimalKVal" value="">
                                            <button type="submit" class="btn btn-primary px-4 py-2.5 flex-center gap-1 shadow-sm">
                                                <i class="ri-play-circle-line fs-16"></i> Jalankan K-Means Optimal
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            let globalResultsData = null;

            document.getElementById('startTestBtn').addEventListener('click', function() {
                const btn = this;
                const btnText = document.getElementById('btnText');
                const btnSpin = document.getElementById('btnSpin');
                
                // Show loading
                btn.disabled = true;
                btnText.classList.add('d-none');
                btnSpin.classList.remove('d-none');

                fetch("{{ route('clustering.silhouette.process') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Hide loading
                    btnText.classList.remove('d-none');
                    btnSpin.classList.add('d-none');
                    btn.disabled = false;

                    if (!data.success) {
                        alert(data.message || "Gagal melakukan pengujian.");
                        return;
                    }

                    globalResultsData = data.results;
                    renderResults(data);
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan sistem saat memproses.");
                    btnText.classList.remove('d-none');
                    btnSpin.classList.add('d-none');
                    btn.disabled = false;
                });
            });

            function renderResults(data) {
                const resultsSection = document.getElementById('resultsSection');
                const tableBody = document.getElementById('comparisonTableBody');
                
                resultsSection.classList.remove('d-none');
                tableBody.innerHTML = "";

                // 1. Populate Table
                const chartCategories = [];
                const chartScores = [];
                let bestScore = -1.0;
                let bestK = 2;
                let bestQuality = "";

                data.results.forEach(row => {
                    chartCategories.push(`K = ${row.k}`);
                    chartScores.push(row.silhouette_score);

                    if (row.silhouette_score > bestScore) {
                        bestScore = row.silhouette_score;
                        bestK = row.k;
                        bestQuality = row.quality;
                    }

                    const isOptimal = row.k === data.optimal_k;
                    const optimalBadge = isOptimal ? '<span class="badge bg-primary fs-10 ms-1">Optimal</span>' : '';
                    const tr = document.createElement('tr');
                    if (isOptimal) tr.className = "table-primary bg-opacity-10";

                    tr.innerHTML = `
                        <td class="text-center fw-bold fs-14">
                            K = ${row.k} ${optimalBadge}
                        </td>
                        <td class="text-end fw-bold text-dark font-monospace">${row.silhouette_score.toFixed(4)}</td>
                        <td class="text-center">
                            <span class="badge bg-${row.quality_class}-subtle text-${row.quality_class} px-2 py-1 fs-12">
                                ${row.quality}
                            </span>
                        </td>
                        <td class="text-center">${row.iterations}</td>
                        <td class="text-end text-muted font-monospace">${row.duration} ms</td>
                        <td class="text-center">
                            <form action="{{ route('clustering.run') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="k" value="${row.k}">
                                <button type="submit" class="btn btn-outline-primary btn-sm flex-center gap-1 mx-auto py-1 px-2.5">
                                    <i class="ri-play-line fs-12"></i> Pilih K ini
                                </button>
                            </form>
                        </td>
                    `;
                    tableBody.appendChild(tr);
                });

                // 2. Render Chart
                renderChart(chartCategories, chartScores, data.optimal_k);

                // 3. Set Recommendation
                document.getElementById('optimalKVal').value = data.optimal_k;
                document.getElementById('recommendationTitle').innerHTML = `Jumlah Klaster Optimal: K = ${data.optimal_k}`;
                document.getElementById('recommendationDesc').innerHTML = `
                    Berdasarkan pengujian Silhouette Coefficient, pengelompokan warga ke dalam <strong>K = ${data.optimal_k} klaster</strong> memberikan performa terbaik dengan skor <strong>${bestScore.toFixed(4)}</strong> (Kualitas struktur: <strong>${bestQuality}</strong>) diselesaikan dalam <strong>${data.results.find(r => r.k === data.optimal_k).iterations} iterasi</strong>.
                `;

                // Scroll to results
                resultsSection.scrollIntoView({ behavior: 'smooth' });
            }

            let chartInstance = null;
            function renderChart(categories, data, optimalK) {
                if (chartInstance) {
                    chartInstance.destroy();
                }

                // Find optimal index to place point annotation
                const optimalIndex = categories.indexOf(`K = ${optimalK}`);

                const options = {
                    series: [{
                        name: 'Silhouette Score',
                        data: data
                    }],
                    chart: {
                        height: 290,
                        type: 'line',
                        toolbar: { show: false },
                        zoom: { enabled: false }
                    },
                    colors: ['#2563eb'],
                    stroke: {
                        width: 4,
                        curve: 'smooth'
                    },
                    markers: {
                        size: 6,
                        colors: ['#2563eb'],
                        strokeColors: '#fff',
                        strokeWidth: 2,
                        hover: { size: 8 }
                    },
                    xaxis: {
                        categories: categories,
                        labels: {
                            style: {
                                fontSize: '12px',
                                fontWeight: 500
                            }
                        }
                    },
                    yaxis: {
                        title: { text: 'Silhouette Score' },
                        min: -0.2,
                        max: 1.0,
                        tickAmount: 6,
                        labels: {
                            formatter: function (value) {
                                return value.toFixed(2);
                            }
                        }
                    },
                    grid: {
                        borderColor: '#f1f5f9',
                        row: {
                            colors: ['transparent'],
                            opacity: 0.5
                        }
                    },
                    annotations: {
                        points: [{
                            x: `K = ${optimalK}`,
                            y: data[optimalIndex],
                            marker: {
                                size: 8,
                                fillColor: '#10b981',
                                strokeColor: '#fff',
                                radius: 2,
                                cssClass: 'apexcharts-custom-class'
                            },
                            label: {
                                borderColor: '#10b981',
                                offsetY: 0,
                                style: {
                                    color: '#fff',
                                    background: '#10b981',
                                    fontSize: '11px',
                                    fontWeight: 700,
                                    padding: { left: 6, right: 6, top: 4, bottom: 4 }
                                },
                                text: 'Optimal'
                            }
                        }]
                    }
                };

                chartInstance = new ApexCharts(document.querySelector("#silhouetteChart"), options);
                chartInstance.render();
            }

            // Export to Excel (CSV)
            document.getElementById('exportExcelBtn').addEventListener('click', function() {
                if (!globalResultsData) return;

                // Build CSV Content
                let csv = "\uFEFF"; // UTF-8 BOM so Excel opens it with proper characters
                csv += "Jumlah Klaster (K);Silhouette Score;Kualitas Struktur;Jumlah Iterasi;Durasi Perhitungan (ms)\n";

                globalResultsData.forEach(row => {
                    // Use semicolon separator for Indonesian locale compatibility in Excel
                    csv += `K = ${row.k};${row.silhouette_score.toFixed(4)};${row.quality};${row.iterations};${row.duration}\n`;
                });

                // Create Blob and download
                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement("a");
                const url = URL.createObjectURL(blob);
                
                link.setAttribute("href", url);
                link.setAttribute("download", `Laporan_Pengujian_Silhouette_GeoPKH_${new Date().toISOString().slice(0,10)}.csv`);
                link.style.visibility = 'hidden';
                
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        </script>
    @endpush
</x-app>

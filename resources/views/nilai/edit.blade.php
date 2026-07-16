<x-app>
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Ubah Skor Kriteria Warga</h6>
                    <p class="text-muted fs-13 mb-0">Ubah data mentah (raw values) indikator kelayakan PKH untuk warga: {{ $warga->nama }}</p>
                </div>
                <a href="{{ route('nilai.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ri-arrow-left-line fs-14"></i> Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title fs-15 border-bottom pb-2 mb-4"><i class="ri-user-line me-2 text-primary"></i> Profil Warga: {{ $warga->nama }}</h5>
                            
                            <form action="{{ route('nilai.update', $warga->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- C1: Pendapatan -->
                                <div class="mb-3">
                                    <label class="form-label">Pendapatan Bulanan (Rp) - [C1]</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="c1" value="{{ old('c1', isset($nilaiWarga['C1']) ? (int)$nilaiWarga['C1']->nilai : '') }}" class="form-control @error('c1') is-invalid @enderror" placeholder="Contoh: 500000" required>
                                    </div>
                                    <div class="fs-12 text-muted mt-1">
                                        Threshold Normalisasi:<br>
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
                                    <div class="fs-12 text-muted mt-1">Skor normalisasi dihitung langsung dari jumlah orang.</div>
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
                                <div class="mb-4">
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

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('nilai.index') }}" class="btn btn-outline-secondary">Batal</a>
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

<x-app>
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="gap-2 page-heading mb-4 flex-column flex-md-row d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-0">Ubah Bobot Kriteria</h6>
                    <p class="text-muted fs-13 mb-0">Sesuaikan persentase bobot atau nama kriteria: {{ $kriterium->kode }} - {{ $kriterium->nama }}</p>
                </div>
                <a href="{{ route('kriteria.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ri-arrow-left-line fs-14"></i> Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form action="{{ route('kriteria.update', $kriterium->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Kode Kriteria</label>
                                    <input type="text" class="form-control font-monospace" value="{{ $kriterium->kode }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Kriteria</label>
                                    <input type="text" name="nama" value="{{ old('nama', $kriterium->nama) }}" class="form-control @error('nama') is-invalid @enderror" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Bobot Persentase (%)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="bobot" value="{{ old('bobot', $kriterium->bobot) }}" class="form-control @error('bobot') is-invalid @enderror" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @error('bobot')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('kriteria.index') }}" class="btn btn-outline-secondary">Batal</a>
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

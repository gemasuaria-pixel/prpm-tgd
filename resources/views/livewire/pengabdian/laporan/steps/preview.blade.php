<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-5">
        {{-- 🧭 Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0 text-primary">
                <i class="bi bi-eye me-2"></i>Pratinjau Laporan Penelitian
            </h5>
            <span class="badge bg-success-subtle text-success px-3 py-2">
                Tahap Akhir
            </span>
        </div>


            {{-- 🧾 Detail Laporan --}}
            <div class="mb-4">
                <h6 class="fw-bold border-bottom pb-2 mb-3 text-uppercase text-secondary">Detail Laporan</h6>
                <dl class="row">
                    <dt class="col-sm-4">Judul Laporan</dt>
                    <dd class="col-sm-8">{{ $laporan['judul'] ?: '-' }}</dd>

                    <dt class="col-sm-4">Ringkasan Laporan</dt>
                    <dd class="col-sm-8">{{ $laporan['ringkasan'] ?: '-' }}</dd>
                </dl>
            </div>

            {{-- 🔗 Luaran Penelitian --}}
            <div class="mb-4">
                <h6 class="fw-bold border-bottom pb-2 mb-3 text-uppercase text-secondary">Luaran Penelitian</h6>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Publikasi / Jurnal</h6>
                        @forelse ($luaran['jurnal'] as $item)
                            <div class="mb-2">
                                <i class="bi bi-journal-text text-primary me-2"></i>{{ $item }}
                            </div>
                        @empty
                            <div class="text-muted">Belum ada data.</div>
                        @endforelse
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Video / Dokumentasi</h6>
                        @forelse ($luaran['video'] as $item)
                            <div class="mb-2">
                                <i class="bi bi-camera-video text-danger me-2"></i>{{ $item }}
                            </div>
                        @empty
                            <div class="text-muted">Belum ada data.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- 📎 File Laporan --}}
            <div class="mb-4">
                <h6 class="fw-bold border-bottom pb-2 mb-3 text-uppercase text-secondary">File Laporan</h6>
                 @if (!empty($file_path))
                        <span class="badge bg-success">Sudah diunggah</span>
                    @else
                        <span class="badge bg-secondary">Belum diunggah</span>
                    @endif
            </div>


            {{-- ✅ Pernyataan --}}
            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" id="pernyataan" wire:model="pernyataan">
                <label class="form-check-label small" for="pernyataan">
                    Saya menyatakan bahwa informasi dan dokumen yang saya serahkan adalah benar.
                </label>
                @error('pernyataan')
                    <div><small class="text-danger">{{ $message }}</small></div>
                @enderror
            </div>

        </div>
    </div>

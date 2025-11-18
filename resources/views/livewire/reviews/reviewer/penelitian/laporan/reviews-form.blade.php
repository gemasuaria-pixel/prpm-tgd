<div class="card border-0 shadow rounded-4">
    <div class="card-body p-4">
        {{-- =============== HEADER LAPORAN =============== --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-primary mb-0">{{ $laporan->proposalPenelitian->judul ?? '-' }}</h5>
            <span class="badge bg-info-subtle text-dark px-3 py-2 text-capitalize">
                {{ str_replace('_', ' ', $laporan->status) }}
            </span>
        </div>

        {{-- =============== INFO DETAIL =============== --}}
        <div class="row g-3 mb-3 small">
            <div class="col-md-6">
                <p><strong>Ketua Pengusul:</strong> {{ $laporan->proposalPenelitian->ketuaPengusul->name ?? '-' }}</p>
                <p><strong>Rumpun Ilmu:</strong> {{ $laporan->proposalPenelitian->rumpun_ilmu ?? '-' }}</p>
                <p><strong>Bidang:</strong> {{ $laporan->proposalPenelitian->bidang_penelitian ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Tahun Pelaksanaan:</strong> {{ $laporan->proposalPenelitian->tahun_pelaksanaan ?? '-' }}</p>
                <p><strong>Dokumen Laporan:</strong></p>
                @if ($laporan->documents->isNotEmpty())
                    @foreach ($laporan->documents as $doc)
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary me-1 mb-1">
                            <i class="bi bi-file-earmark-text me-1"></i> Laporan
                        </a>
                        
                    @endforeach
                @endif
            </div>
        </div>

        {{-- =============== ANGGOTA PENELITIAN =============== --}}
        @if ($laporan->proposalPenelitian->anggota->isNotEmpty())
            <div class="mb-4">
                <h6 class="fw-semibold text-secondary mb-2">Anggota Penelitian</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>NIDN</th>
                                <th>Alamat</th>
                                <th>Kontak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporan->proposalPenelitian->anggota as $a)
                                <tr>
                                    <td>{{ $a->individu->name ?? '-' }}</td>
                                    <td>{{ $a->individu->nidn ?? '-' }}</td>
                                    <td>{{ $a->individu->alamat ?? '-' }}</td>
                                    <td>{{ $a->individu->kontak ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- =============== REVIEW SEBELUMNYA =============== --}}
        @if ($laporan->reviews->isNotEmpty())
            <div class="mb-4">
                <h6 class="fw-semibold text-secondary mb-2">Review Sebelumnya</h6>
                <div class="list-group">
                    @foreach ($laporan->reviews as $review)
                        <div class="list-group-item border-start border-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $review->reviewer->name ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $review->created_at->format('d F Y') }}</small>
                                </div>
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst(str_replace('_', ' ', $review->status)) }}
                                </span>
                            </div>
                            <p class="mb-0 mt-2 small text-muted fst-italic">{{ $review->komentar ?? '-' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <hr>

        {{-- =============== FORM REVIEW LAPORAN =============== --}}
        <div class="mt-4">
            <h5 class="fw-semibold text-success mb-3">
                <i class="bi bi-pencil-square me-2"></i>Form Review Laporan Penelitian
            </h5>

            <form wire:submit.prevent="simpanReview" class="needs-validation" novalidate>
                <div class="row g-3">
                    {{-- STATUS REVIEW --}}
                    <div class="col-md-6">
                        <label for="status" class="form-la bel fw-semibold">Status Review</label>
                        <select wire:model="status" id="status" class="form-select">
                            <option value="">-- Pilih Status --</option>
                            <option value="approved">Disetujui</option>
                            <option value="revisi">Perlu Revisi</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>

                    {{-- KOMENTAR --}}
                    <div class="col-12">
                        <label for="komentar" class="form-label fw-semibold">Komentar / Catatan</label>
                        <textarea wire:model="komentar" id="komentar" class="form-control" rows="4"
                            placeholder="Tulis komentar atau catatan untuk dosen pengusul..."></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a wire:navigate href="{{ route('reviewer.review.penelitian.laporan.index') }}"
                        class="btn btn-light border">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-save me-1"></i> Simpan Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

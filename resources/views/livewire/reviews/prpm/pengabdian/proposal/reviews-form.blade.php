<div class="card border-0 shadow rounded-4">
    <div class="card-body p-4">
        {{-- =============== HEADER PROPOSAL =============== --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-primary mb-0">{{ $proposal->judul ?? '-' }}</h5>
            <span class="badge bg-info-subtle text-dark px-3 py-2 text-capitalize">
                {{ str_replace('_', ' ', $proposal->status) }}
            </span>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6 small">
                <p><strong>Ketua Pengusul:</strong> {{ $proposal->ketuaPengusul->name ?? '-' }}</p>
                <p><strong>Bidang Pengabdian:</strong> {{ $proposal->bidang_pengabdian ?? '-' }}</p>
                <p><strong>Lokasi Kegiatan:</strong> {{ $proposal->lokasi_kegiatan ?? '-' }}</p>
            </div>
            <div class="col-md-6 small">
                <p><strong>Tahun Pelaksanaan:</strong> {{ $proposal->tahun_pelaksanaan ?? '-' }}</p>
                <p><strong>Dokumen Proposal:</strong></p>
                @if ($proposal->documents->isNotEmpty())
                    @foreach ($proposal->documents as $doc)
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary me-1 mb-1">
                            <i class="bi bi-file-earmark-text me-1"></i> {{ ucfirst($doc->tipe) }}
                        </a>
                    @endforeach
                @else
                    <span class="text-muted">Belum ada dokumen</span>
                @endif
            </div>
        </div>

        {{-- =============== ANGGOTA =============== --}}
        @if ($proposal->anggota->isNotEmpty())
            <div class="mb-4">
                <h6 class="fw-semibold text-secondary mb-2">Anggota Pengabdian</h6>
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
                            @foreach ($proposal->anggota as $a)
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
        @if ($proposal->reviews->isNotEmpty())
            <div class="mb-4">
                <h6 class="fw-semibold text-secondary mb-2">Review Sebelumnya</h6>
                <div class="list-group">
                    @foreach ($proposal->reviews as $review)
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

        {{-- =============== FORM UPDATE STATUS =============== --}}
        <div class="mt-4">
            <h5 class="fw-semibold text-success mb-3">
                <i class="bi bi-pencil-square me-2"></i>Perbarui Status Proposal
            </h5>

            <form wire:submit.prevent="updateStatus" class="needs-validation" novalidate>
                <div class="row g-3">

                    {{-- STATUS --}}
                    <div class="col-md-6">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select wire:model="status" id="status" class="form-select"
                            {{ $allApproved || $proposal->status === 'final' ? 'disabled' : '' }}>
                            @if (!$allApproved)
                                <option class="disabled text-muted" value="" disabled selected>-- Pilih Status --</option>
                                <option value="menunggu_validasi_reviewer">Kirim ke Reviewer</option>
                                <option value="revisi">Minta Revisi</option>
                                <option value="rejected">Tolak</option>
                            @else
                                <option value="final" selected>Semua reviewer sudah approve</option>
                            @endif
                        </select>
                    </div>

                    {{-- REVIEWER PICKER --}}
                    <div class="col-md-6" 
                        x-data="reviewerPicker($el.dataset.reviewers, @entangle('reviewer_id'))" 
                        x-init="init()" 
                        data-reviewers='@json($reviewers)'
                        x-show="$wire.status === 'menunggu_validasi_reviewer'" x-transition>

                        <label class="form-label fw-semibold">Tugaskan Reviewer</label>

                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Cari nama reviewer..."
                                x-model="search" @focus="open = true" @click.away="open = false"
                                {{ $proposal->status === 'final' ? 'disabled' : '' }}>

                            <ul class="list-group position-absolute w-100 mt-1 shadow-sm rounded-3"
                                x-show="open && filteredReviewers.length" style="z-index:1000;">
                                <template x-for="rev in filteredReviewers" :key="rev.id">
                                    <li class="list-group-item list-group-item-action py-2 px-3"
                                        @click="addReviewer(rev)" x-text="rev.name"></li>
                                </template>
                            </ul>
                        </div>

                        <div class="mt-2 d-flex flex-wrap gap-1">
                            <template x-for="(rev, i) in selectedReviewers" :key="rev.id">
                                <span class="badge bg-primary px-2 py-1 d-inline-flex align-items-center">
                                    <span x-text="rev.name"></span>
                                    <button type="button" class="btn-close btn-close-white ms-2"
                                        style="font-size: .6rem"
                                        @click="selectedIds.splice(i, 1); $wire.reviewer_id = selectedIds"
                                        {{ $proposal->status === 'final' || $allApproved ? 'disabled' : '' }}>
                                    </button>
                                </span>
                            </template>
                            <p class="text-muted small mt-1" x-show="!selectedReviewers.length">
                                Belum ada reviewer dipilih.
                            </p>
                        </div>
                    </div>

                    {{-- KOMENTAR --}}
                    <div class="col-12">
                        <label for="komentar_prpm" class="form-label fw-semibold">Catatan / Komentar</label>
                        <textarea wire:model="komentar_prpm" id="komentar_prpm" class="form-control" rows="3"
                            placeholder="Tulis komentar atau catatan untuk dosen pengusul..."></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a wire:navigate href="{{ route('ketua-prpm.review.pengabdian.proposal.index') }}"
                        class="btn btn-light border">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>

                    @if ($allApproved && $proposal->status !== 'final')
                        <button type="button" wire:click="updateStatus" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle me-1"></i> Finalkan Proposal
                        </button>
                    @endif

                    @if (!$allApproved && $proposal->status !== 'final')
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function reviewerPicker(reviewersJson, selected) {
                const allReviewers = JSON.parse(reviewersJson);
                return {
                    allReviewers,
                    selectedIds: selected,
                    search: '',
                    open: false,

                    get filteredReviewers() {
                        if (!this.search) return [];
                        return this.allReviewers
                            .filter(r =>
                                r.name.toLowerCase().includes(this.search.toLowerCase()) &&
                                !this.selectedIds.includes(r.id)
                            )
                            .slice(0, 8);
                    },

                    get selectedReviewers() {
                        return this.allReviewers.filter(r => this.selectedIds.includes(r.id));
                    },

                    init() {},

                    addReviewer(rev) {
                        if (!this.selectedIds.includes(rev.id)) {
                            this.selectedIds.push(rev.id);
                            this.search = '';
                            this.open = false;
                        }
                    },

                    removeReviewer(i) {
                        this.selectedIds.splice(i, 1);
                    }
                }
            }

            window.addEventListener('toast', event => {
                Swal.fire({
                    icon: event.detail.type || 'info',
                    toast: true,
                    position: 'top-end',
                    title: event.detail.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        </script>
    @endpush
</div>

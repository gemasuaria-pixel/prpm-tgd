<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Judul</th>
                <th>Ketua Pengusul</th>
                <th>Rumpun Ilmu</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($proposals as $proposal)
                @php
                    $statusClass = match ($proposal->status) {
                        'approved_by_prpm' => 'bg-success-subtle text-success fw-semibold',
                        'rejected' => 'bg-danger-subtle text-danger fw-semibold',
                        'revisi' => 'bg-warning-subtle text-warning fw-semibold',
                        'final' => 'bg-primary-subtle text-primary fw-semibold',
                        default => 'bg-secondary-subtle text-secondary fw-semibold',
                    };
                @endphp
                <tr>
                    <td class="fw-semibold text-wrap">{{ $proposal->judul }}</td>
                    <td>{{ $proposal->ketuaPengusul->name ?? '-' }}</td>
                    <td>{{ $proposal->rumpun_ilmu ?? '-' }}</td>
                    <td>
                        <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                            {{ ucfirst(str_replace('_', ' ', $proposal->status ?? 'menunggu')) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-light btn-sm border rounded-pill px-3"
                            data-bs-toggle="modal" data-bs-target="#modalDetail{{ $proposal->id }}">
                            <i class="bi bi-eye text-primary"></i> Detail
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        Tidak ada usulan yang menunggu persetujuan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modals -->
@foreach ($proposals as $proposal)
    @php
        $statusClass = match ($proposal->status) {
            'approved_by_prpm' => 'bg-success-subtle text-success fw-semibold',
            'rejected' => 'bg-danger-subtle text-danger fw-semibold',
            'revisi' => 'bg-warning-subtle text-warning fw-semibold',
            'final' => 'bg-primary-subtle text-primary fw-semibold',
            default => 'bg-secondary-subtle text-secondary fw-semibold',
        };
    @endphp
    <div class="modal fade" id="modalDetail{{ $proposal->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-semibold">Detail Proposal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light p-4">
                    <!-- Header Proposal -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body">
                            <h4 class="fw-bold text-primary mb-1">{{ $proposal->judul }}</h4>
                            <p class="text-muted mb-4">
                                Diajukan oleh: {{ $proposal->ketuaPengusul->name ?? '-' }}
                            </p>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <i class="bi bi-bookmark-star fs-5 text-primary me-3"></i>
                                        <div>
                                            <small class="text-muted">Rumpun Ilmu</small>
                                            <p class="fw-semibold mb-0">{{ $proposal->rumpun_ilmu ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <i class="bi bi-calendar-event fs-5 text-primary me-3"></i>
                                        <div>
                                            <small class="text-muted">Tahun Pelaksanaan</small>
                                            <p class="fw-semibold mb-0">{{ $proposal->tahun_pelaksanaan }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Abstrak & Dokumen -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body">
                                    <h6 class="fw-semibold text-primary mb-2">Abstrak</h6>
                                    <p class="text-muted" style="white-space: pre-line;">
                                        {{ $proposal->abstrak ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body">
                                    <h6 class="fw-semibold text-primary mb-3">Dokumen</h6>
                                    @if ($proposal->documents->isNotEmpty())
                                        @foreach ($proposal->documents as $doc)
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                                class="btn btn-outline-secondary w-100 text-start mb-2">
                                                <i class="bi bi-file-earmark-text me-2"></i>
                                                {{ ucfirst($doc->tipe) }}
                                            </a>
                                        @endforeach
                                    @else
                                        <em class="text-muted">Belum diunggah</em>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hasil Review -->
                    @if ($proposal->reviews->isNotEmpty())
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body">
                                <h6 class="fw-semibold text-primary mb-2">Hasil Review</h6>
                                <div class="list-group list-group-flush">
                                    @foreach ($proposal->reviews as $review)
                                        <div class="list-group-item px-0">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1 fw-semibold">{{ $review->reviewer->name }}</h6>
                                                <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                                            </div>
                                            <p class="mb-1">{{ $review->komentar ?? '-' }}</p>
                                            <span class="badge 
                                                @if ($review->status == 'approved_by_prpm') bg-success-subtle text-success 
                                                @elseif($review->status == 'rejected') bg-danger-subtle text-danger 
                                                @else bg-warning-subtle text-warning @endif">
                                                {{ ucfirst(str_replace('_',' ',$review->status)) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Update Status -->
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h6 class="fw-semibold text-primary mb-3">Tinjau & Perbarui Status</h6>
                            <form action="{{ route('ketua-prpm.prpm.review.updateStatus', $proposal->id) }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Status PRPM</label>
                                        <select name="status" class="form-select" required>
                                            <option value="">Pilih Status</option>
                                            <option value="approved_by_prpm" {{ $proposal->status == 'approved_by_prpm' ? 'selected' : '' }}>Setujui & Tugaskan Reviewer</option>
                                            <option value="rejected" {{ $proposal->status == 'rejected' ? 'selected' : '' }}>Tolak</option>
                                            <option value="revisi" {{ $proposal->status == 'revisi' ? 'selected' : '' }}>Minta Revisi</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tugaskan Reviewer</label>
                                        <select name="reviewer_id[]" class="form-select" multiple>
                                            @foreach ($reviewers as $reviewer)
                                                <option value="{{ $reviewer->id }}" {{ in_array($reviewer->id, $proposal->reviews->pluck('reviewer_id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $reviewer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Tekan Ctrl/Cmd untuk memilih lebih dari satu.</small>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Catatan PRPM</label>
                                        <textarea name="komentar_prpm" class="form-control" rows="3" placeholder="Berikan catatan atau alasan (opsional)">{{ $proposal->komentar_prpm ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- /modal-body -->
            </div>
        </div>
    </div>
@endforeach

<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Judul Laporan</th>
                <th>Ketua Pengusul</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $laporan)
                @php
                    $statusClass = match ($laporan->status_prpm) {
                        'approved' => 'bg-success-subtle text-success fw-semibold',
                        'rejected' => 'bg-danger-subtle text-danger fw-semibold',
                        'revision' => 'bg-warning-subtle text-warning fw-semibold',
                        default => 'bg-secondary-subtle text-secondary fw-semibold',
                    };
                @endphp
                <tr>
                    <td class="fw-semibold text-wrap">{{ $laporan->proposal->judul ?? '-' }}</td>
                    <td>{{ $laporan->proposal->ketua_pengusul ?? '-' }}</td>
                    <td>
                        <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                            {{ ucfirst($laporan->status_prpm ?? 'Menunggu') }}
                        </span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-light btn-sm border rounded-pill px-3" data-bs-toggle="modal"
                            data-bs-target="#modalLaporan{{ $laporan->id }}">
                            <i class="bi bi-eye text-primary"></i> Detail
                        </button>
                    </td>
                </tr>

                {{-- Modal Detail Laporan --}}
                <div class="modal fade" id="modalLaporan{{ $laporan->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title fw-semibold">Detail Laporan Penelitian</h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body bg-light">
                                <h5 class="fw-bold mb-4 text-primary">{{ $laporan->proposal->judul ?? '-' }}</h5>

                                <div class="row mb-4 g-3">
                                    <div class="col-md-6">
                                        <div class="p-3 bg-white rounded-3 shadow-sm h-100">
                                            <p><strong>Ketua Pengusul:</strong>
                                                {{ $laporan->proposal->ketua_pengusul ?? '-' }}</p>
                                            <p><strong>Rumpun Ilmu:</strong>
                                                {{ $laporan->proposal->rumpun_ilmu ?? '-' }}</p>
                                            <p><strong>Tahun Pelaksanaan:</strong>
                                                {{ $laporan->proposal->tahun_pelaksanaan ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 bg-white rounded-3 shadow-sm h-100">
                                            <p><strong>Status PRPM:</strong>
                                                <span class="badge {{ $statusClass }}">
                                                    {{ ucfirst($laporan->status_prpm ?? 'Menunggu') }}
                                                </span>
                                            </p>
                                            <p><strong>Metode Penelitian:</strong>
                                                {{ $laporan->metode_penelitian ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-semibold text-primary mb-2">Abstrak</h6>
                                        <p class="text-muted" style="white-space: pre-line;">
                                            {{ $laporan->abstrak ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-semibold text-primary mb-2">Dokumen Laporan</h6>
                                        @if ($laporan->documents->isNotEmpty())
                                            @foreach ($laporan->documents as $doc)
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                                    class="btn btn-outline-secondary btn-sm rounded-pill me-2 mb-2">
                                                    <i class="bi bi-file-earmark-text"></i>
                                                    {{ ucfirst($doc->tipe) }}
                                                </a>
                                            @endforeach
                                        @else
                                            <em class="text-muted">Belum diunggah</em>
                                        @endif
                                    </div>
                                </div>

                                {{-- Hasil Review --}}
                                @if ($laporan->reviews->isNotEmpty())
                                    <div class="card border-0 shadow-sm mb-4">
                                        <div class="card-body">
                                            <h6 class="fw-semibold text-primary mb-2">Hasil Review Reviewer</h6>
                                            <div class="list-group list-group-flush">
                                                @foreach ($laporan->reviews as $review)
                                                    <div class="list-group-item border-bottom py-2">
                                                        <strong>{{ $review->reviewer->name ?? 'Reviewer' }}</strong>
                                                        <span
                                                            class="badge 
                            @if ($review->status == 'approved') bg-success 
                            @elseif($review->status == 'rejected') bg-danger 
                            @else bg-warning @endif">
                                                            {{ ucfirst($review->status) }}
                                                        </span>
                                                        <br>
                                                        <small
                                                            class="text-muted">{{ $review->created_at->format('d M Y H:i') }}</small>
                                                        <p class="mt-2 mb-0">{{ $review->komentar ?? '-' }}</p>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @php
                                                $jumlahReviewer = $laporan->reviews->count();
                                                $jumlahApproved = $laporan->reviews
                                                    ->where('status', 'approved')
                                                    ->count();
                                                $semuaApproved =
                                                    $jumlahReviewer > 0 && $jumlahApproved === $jumlahReviewer;
                                            @endphp

                                            @if ($semuaApproved && $laporan->status_prpm !== 'final')
                                                <div
                                                    class="alert alert-success mt-3 d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>Semua reviewer telah menyetujui!</strong>
                                                        Ketua PRPM dapat melakukan final approve.
                                                    </div>
                                                    <form
                                                        action="{{ route('ketua-prpm.prpm.review.updateStatusLaporan', $laporan->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status_prpm" value="final">
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm rounded-pill">
                                                            Final Approve
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif


                                {{-- Assign Reviewer & Update Status --}}
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="fw-semibold text-primary mb-3">Tinjau & Perbarui Status</h6>
                                        <form
                                            action="{{ route('ketua-prpm.prpm.review.updateStatusLaporan', $laporan->id) }}"
                                            method="POST">
                                            @csrf
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Status PRPM</label>
                                                    <select name="status_prpm" class="form-select form-select-sm"
                                                        required>
                                                        <option value="">Pilih Status</option>
                                                        <option value="approved"
                                                            {{ $laporan->status_prpm == 'approved' ? 'selected' : '' }}>
                                                            Setujui & Tugaskan Reviewer</option>
                                                        <option value="rejected"
                                                            {{ $laporan->status_prpm == 'rejected' ? 'selected' : '' }}>
                                                            Tolak</option>
                                                        <option value="revision"
                                                            {{ $laporan->status_prpm == 'revision' ? 'selected' : '' }}>
                                                            Minta Revisi</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Tugaskan Reviewer</label>
                                                    <select name="reviewer_id[]" class="form-select form-select-sm"
                                                        multiple>
                                                        @foreach ($reviewers as $reviewer)
                                                            <option value="{{ $reviewer->id }}">{{ $reviewer->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small class="text-muted">Tekan Ctrl/Cmd untuk memilih lebih dari
                                                        satu.</small>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Catatan PRPM</label>
                                                    <textarea name="komentar_prpm" class="form-control" rows="3" placeholder="Catatan (opsional)">{{ $laporan->komentar_prpm ?? '' }}</textarea>
                                                </div>
                                            </div>

                                            <div class="mt-4 text-end">
                                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                                    <i class="bi bi-save"></i> Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">Belum ada laporan penelitian.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

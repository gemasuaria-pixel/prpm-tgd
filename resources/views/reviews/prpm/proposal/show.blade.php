@extends('layouts.main')

@section('title', 'Detail Proposal Penelitian')

@section('content')
<main class="app-main">
    <x-breadcrumbs>Review Proposal</x-breadcrumbs>

    <div class="app-content">
        <div class="container-fluid">

            {{-- Tombol Kembali --}}
            <div class="mb-4">
                <a href="{{ route('ketua-prpm.review.proposal.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-3">{{ $proposal->judul }}</h3>
                    <p class="text-muted">Diajukan oleh: <strong>{{ $proposal->ketuaPengusul->name ?? '-' }}</strong></p>

                    {{-- Info Dasar --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 border rounded bg-light">
                                <small class="text-muted d-block">Rumpun Ilmu</small>
                                <span class="fw-semibold">{{ $proposal->rumpun_ilmu ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded bg-light">
                                <small class="text-muted d-block">Tahun Pelaksanaan</small>
                                <span class="fw-semibold">{{ $proposal->tahun_pelaksanaan ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded bg-light">
                                <small class="text-muted d-block">Bidang Penelitian</small>
                                <span class="fw-semibold">{{ $proposal->bidang_penelitian ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Abstrak --}}
                    <div class="mb-4">
                        <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="bi bi-file-text me-2"></i>Abstrak</h5>
                        <p class="text-secondary">{{ $proposal->abstrak ?? 'Abstrak belum tersedia.' }}</p>
                    </div>

                    {{-- Dokumen --}}
                    <div class="mb-4">
                        <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="bi bi-folder me-2"></i>Dokumen Proposal</h5>
                        @if ($proposal->documents->isNotEmpty())
                            <div class="list-group">
                                @foreach ($proposal->documents as $doc)
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="list-group-item list-group-item-action">
                                        <i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>{{ ucfirst($doc->tipe) }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-light border">Belum ada dokumen diunggah.</div>
                        @endif
                    </div>

                    {{-- Anggota Dosen --}}
                    @if ($proposal->anggotaDosen->isNotEmpty())
                        <div class="mb-4">
                            <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="bi bi-people me-2"></i>Anggota Tim Dosen</h5>
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
                                        @foreach ($proposal->anggotaDosen as $a)
                                            <tr>
                                                <td>{{ $a->user->name ?? '-' }}</td>
                                                <td>{{ $a->user->nidn ?? '-' }}</td>
                                                <td>{{ $a->user->alamat ?? '-' }}</td>
                                                <td>{{ $a->user->kontak ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    {{-- Review Sebelumnya --}}
                    @if ($proposal->reviews->isNotEmpty())
                        <div class="mb-4">
                            <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="bi bi-chat-left-text me-2"></i>Review Sebelumnya</h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($proposal->reviews as $review)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong>{{ $review->reviewer->name }}</strong><br>
                                                <small class="text-muted">{{ $review->created_at->format('d F Y') }}</small>
                                            </div>
                                            <span class="badge bg-light text-dark">{{ ucfirst(str_replace('_', ' ', $review->status)) }}</span>
                                        </div>
                                        <p class="mb-0 mt-2 text-muted fst-italic">{{ $review->komentar ?? '-' }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Update Status --}}
                    <div class="border-top pt-4">
                        <h5 class="fw-bold mb-3 text-success"><i class="bi bi-pencil-square me-2"></i>Perbarui Status PRPM</h5>
                        <form action="{{ route('ketua-prpm.review.proposal.updateStatus', $proposal) }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="approved_by_prpm" {{ $proposal->status == 'approved_by_prpm' ? 'selected' : '' }}>Setujui</option>
                                        <option value="rejected" {{ $proposal->status == 'rejected' ? 'selected' : '' }}>Tolak</option>
                                        <option value="revisi" {{ $proposal->status == 'revisi' ? 'selected' : '' }}>Minta Revisi</option>
                                        <option value="pending" {{ $proposal->status == 'pending' ? 'selected' : '' }}>Tunda</option>
                                    </select>
                                </div>
                               <div class="col-md-6">
    <label for="reviewer_id" class="form-label fw-semibold">Tugaskan Reviewer</label>
    <select name="reviewer_id[]" id="reviewer_id" multiple class="form-select">
        @foreach ($reviewers as $reviewer)
            <option value="{{ $reviewer->id }}"
                {{ in_array($reviewer->id, $proposal->reviews->pluck('reviewer_id')->toArray()) ? 'selected' : '' }}>
                {{ $reviewer->name }} — {{ $reviewer->nidn }}
            </option>
        @endforeach
    </select>
    <small class="text-muted">Ketik untuk mencari reviewer dengan cepat.</small>
</div>

{{-- Tambahkan CDN Tom Select (di bawah atau di section scripts) --}}
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        new TomSelect("#reviewer_id", {
            plugins: ['remove_button'],
            maxItems: null,
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: "Cari dan pilih reviewer..."
        });
    });
</script>

                                <div class="col-12">
                                    <label for="komentar_prpm" class="form-label">Catatan / Komentar</label>
                                    <textarea name="komentar_prpm" id="komentar_prpm" class="form-control" rows="3">{{ $proposal->komentar_prpm ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-success px-4">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection
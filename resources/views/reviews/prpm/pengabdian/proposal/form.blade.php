@extends('layouts.main')

@section('title', 'Detail Proposal Pengabdian')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">
@endpush

@section('content')
<div class="container mt-4">

    <h4 class="mb-4">Detail Proposal Pengabdian</h4>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            {{-- ================== INFORMASI PROPOSAL ================== --}}
            <h5 class="fw-semibold text-primary mb-3">{{ $proposal->judul ?? '-' }}</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Ketua Pengusul:</strong> {{ $proposal->ketuaPengusul->name ?? '-' }}</p>
                    <p><strong>Rumpun Ilmu:</strong> {{ $proposal->rumpun_ilmu ?? '-' }}</p>
                    <p><strong>Bidang Pengabdian:</strong> {{ $proposal->bidang_pengabdian ?? '-' }}</p>
                    <p><strong>Tahun Pelaksanaan:</strong> {{ $proposal->tahun_pelaksanaan ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Lokasi Pengabdian:</strong> {{ $proposal->lokasi ?? '-' }}</p>
                    <p><strong>Luaran Tambahan Dijanjikan:</strong> {{ $proposal->luaran_tambahan_dijanjikan ?? '-' }}</p>

                    {{-- Dokumen Proposal --}}
                    <p><strong>Dokumen Proposal:</strong><br>
                        @if ($proposal->documents->isNotEmpty())
                            @foreach ($proposal->documents as $doc)
                                <a href="{{ asset('storage/' . $doc->file_path) }}" class="btn btn-sm btn-outline-primary mt-1" target="_blank">
                                    <i class="bi bi-file-earmark-text me-1"></i> {{ ucfirst($doc->tipe) }}
                                </a>
                            @endforeach
                        @else
                            <span class="text-muted">Belum ada dokumen</span>
                        @endif
                    </p>
                </div>
            </div>

            {{-- ================== ABSTRAK ================== --}}
            <div class="mb-4">
                <strong>Abstrak:</strong>
                <div class="border rounded p-3 bg-light mt-1">
                    {{ $proposal->abstrak ?? 'Belum ada abstrak.' }}
                </div>
            </div>

            {{-- ================== MITRA ================== --}}
            <div class="mb-4">
                <strong>Informasi Mitra:</strong>
                <div class="border rounded p-3 bg-light mt-2">
                    <p><strong>Nama Mitra:</strong> {{ $proposal->nama_mitra ?? '-' }}</p>
                    <p><strong>Alamat Mitra:</strong> {{ $proposal->alamat_mitra ?? '-' }}</p>
                    <p><strong>Kontak Mitra:</strong> {{ $proposal->kontak_mitra ?? '-' }}</p>
                    <p><strong>Bentuk Kegiatan:</strong> {{ $proposal->bentuk_kegiatan ?? '-' }}</p>
                </div>
            </div>

          {{-- ================== ANGGOTA DOSEN ================== --}}
@if ($proposal->anggotaDosen->isNotEmpty())
<div class="mb-4">
    <h6 class="fw-semibold mb-2"><i class="bi bi-person-badge me-1"></i>Anggota Dosen</h6>
    <div class="table-responsive">
        <table class="table table-hover table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Prodi</th>
                    <th>NIDN</th>
                    <th>Kontak</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proposal->anggotaDosen as $d)
                <tr>
                    <td>{{ $d->user->name ?? '-' }}</td>
                    <td>{{ $d->user->program_studi ?? '-' }}</td>
                    <td>{{ $d->user->nidn ?? '-' }}</td>
                    <td>{{ $d->user->kontak ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ================== ANGGOTA MAHASISWA ================== --}}
@if ($proposal->anggotaMahasiswa->isNotEmpty())
<div class="mb-4">
    <h6 class="fw-semibold mb-2"><i class="bi bi-people me-1"></i>Anggota Mahasiswa</h6>
    <div class="table-responsive">
        <table class="table table-hover table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Program Studi</th>
                    <th>NIM</th>
                    <th>Kontak</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proposal->anggotaMahasiswa as $m)
                <tr>
                    <td>{{ $m->nama ?? $m->user->name ?? '-' }}</td>
                    <td>{{ $m->program_studi ?? $m->user->program_studi ?? '-' }}</td>
                    <td>{{ $m->nim ?? $m->user->nim ?? '-' }}</td>
                    <td>{{ $m->kontak ?? $m->user->kontak ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif


            {{-- ================== REVIEWER & REVIEW ================== --}}
            @if ($proposal->reviews->isNotEmpty())
            <div class="mb-4">
                <strong>Review oleh Reviewer:</strong>
                <ul class="list-group list-group-flush mt-2">
                    @foreach ($proposal->reviews as $review)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $review->reviewer->name ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $review->created_at->format('d F Y') }}</small>
                                </div>
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst(str_replace('_', ' ', $review->status)) }}
                                </span>
                            </div>
                            <p class="mb-0 mt-2 text-muted fst-italic">{{ $review->komentar ?? '-' }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <hr>

            {{-- ================== FORM UPDATE STATUS ================== --}}
            @php
                $totalReviewer = $proposal->reviews->count();
                $approvedCount = $proposal->reviews->where('status', 'approved')->count();
                $allApproved = $totalReviewer > 0 && $approvedCount === $totalReviewer;
            @endphp

            <div class="mt-4">
                <h5 class="fw-semibold mb-3 text-success">
                    <i class="bi bi-pencil-square me-2"></i>Perbarui Status Proposal
                </h5>

                <form action="{{ route('ketua-prpm.review.pengabdian.proposal.update-status', $proposal->id) }}" method="POST">
                    @csrf
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select" required>
                                @if (!$allApproved)
                                    <option value="">-- Pilih Status --</option>
                                    <option value="menunggu_validasi_reviewer" {{ $proposal->status == 'menunggu_validasi_reviewer' ? 'selected' : '' }}>Kirim ke Reviewer</option>
                                    <option value="revisi" {{ $proposal->status == 'revisi' ? 'selected' : '' }}>Minta Revisi</option>
                                    <option value="rejected" {{ $proposal->status == 'rejected' ? 'selected' : '' }}>Tolak</option>
                                @else
                                    <option value="final" selected>Final (Semua reviewer telah menyetujui)</option>
                                @endif
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tugaskan Reviewer</label>
                            <select name="reviewer_id[]" id="reviewer_id" multiple class="form-select" {{ $allApproved ? 'disabled' : '' }}>
                                @foreach ($reviewers as $reviewer)
                                    <option value="{{ $reviewer->id }}"
                                        {{ in_array($reviewer->id, $proposal->reviews->pluck('reviewer_id')->toArray()) ? 'selected' : '' }}>
                                        {{ $reviewer->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">
                                {{ $allApproved ? 'Tidak dapat mengubah reviewer karena semua sudah approve.' : 'Ketik untuk mencari reviewer.' }}
                            </small>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Catatan / Komentar</label>
                            <textarea name="komentar_prpm" class="form-control" rows="3">{{ $proposal->komentar_prpm ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('ketua-prpm.review.pengabdian.proposal.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        new TomSelect("#reviewer_id", {
            plugins: ['remove_button'],
            maxItems: null,
            create: false,
            sortField: { field: "text", direction: "asc" },
            placeholder: "Cari reviewer..."
        });
    });
</script>
@endpush

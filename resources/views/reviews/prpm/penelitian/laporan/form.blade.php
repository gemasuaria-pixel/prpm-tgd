@extends('layouts.main')

@section('title', 'Detail Laporan Penelitian')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">
@endpush

@section('content')
    <div class="container mt-4">
        <h4 class="mb-4">Detail Laporan Penelitian</h4>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">

                {{-- ================== INFORMASI LAPORAN ================== --}}
                <h5 class="fw-semibold text-primary mb-3">
                    {{ $laporan->judul ?? '-' }}
                </h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Ketua Pengusul:</strong> {{ $laporan->proposalPenelitian->ketuaPengusul->name ?? '-' }}
                        </p>
                        <p><strong>Rumpun Ilmu:</strong> {{ $laporan->proposalPenelitian->rumpun_ilmu ?? '-' }}</p>
                        <p><strong>Bidang Penelitian:</strong> {{ $laporan->proposalPenelitian->bidang_penelitian ?? '-' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tahun Pelaksanaan:</strong> {{ $laporan->proposalPenelitian->tahun_pelaksanaan ?? '-' }}
                        </p>
                        <p><strong>Luaran Tambahan Dijanjikan:</strong>
                            {{ $laporan->proposalPenelitian->luaran_tambahan_dijanjikan ?? '-' }}</p>
                        <p>
                            <strong>Dokumen Laporan:</strong><br>
                            @if ($laporan->documents->isNotEmpty())
                                @foreach ($laporan->documents as $doc)
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary mt-1">
                                        <i class="bi bi-file-earmark-text me-1"></i> {{ ucfirst($doc->tipe) }}
                                    </a>
                                @endforeach
                            @else
                                <span class="text-muted">Belum ada dokumen</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- ================== RINGKASAN & ABSTRAK ================== --}}
                <div class="mb-4">
                    <strong>Ringkasan Laporan:</strong>
                    <div class="border rounded p-3 bg-light mt-1">
                        {{ $laporan->ringkasan_laporan ?? 'Belum ada ringkasan.' }}
                    </div>
                </div>

                <div class="mb-4">
                    <strong>Abstrak:</strong>
                    <div class="border rounded p-3 bg-light mt-1">
                        {{ $laporan->abstrak ?? 'Belum ada abstrak.' }}
                    </div>
                </div>

                {{-- ================== ANGGOTA PENELITIAN ================== --}}
                @if ($laporan->proposalPenelitian && $laporan->proposalPenelitian->anggotaDosen->isNotEmpty())
                    <div class="mb-4">
                        <strong>Daftar Anggota Penelitian:</strong>
                        <div class="table-responsive mt-2">
                            <table class="table table-sm table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIDN</th>
                                        <th>Alamat</th>
                                        <th>Kontak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporan->proposalPenelitian->anggotaDosen as $anggota)
                                        <tr>
                                            <td>{{ $anggota->user->name ?? '-' }}</td>
                                            <td>{{ $anggota->user->nidn ?? '-' }}</td>
                                            <td>{{ $anggota->user->alamat ?? '-' }}</td>
                                            <td>{{ $anggota->user->kontak ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                {{-- ================== LINK EKSTERNAL (VIDEO / JURNAL) ================== --}}
                @if (!empty($laporan->external_links))
                    @php
                        $externalLinks = json_decode($laporan->external_links, true);
                    @endphp
                    @if (!empty($externalLinks))
                        <div class="mb-4">
                            <strong>Link Eksternal:</strong>
                            <ul class="list-group list-group-flush mt-2">
                                @foreach ($externalLinks as $link)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            @if ($link['type'] === 'video')
                                                <i class="bi bi-play-circle text-danger me-1"></i>
                                                <strong>Video:</strong>
                                            @elseif ($link['type'] === 'jurnal')
                                                <i class="bi bi-journal-text text-primary me-1"></i>
                                                <strong>Jurnal:</strong>
                                            @else
                                                <i class="bi bi-link-45deg text-secondary me-1"></i>
                                                <strong>Link:</strong>
                                            @endif
                                            <a href="{{ $link['url'] }}" target="_blank">{{ $link['url'] }}</a>
                                        </div>
                                        <span class="badge bg-light text-dark text-capitalize">{{ $link['type'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif


                {{-- ================== REVIEW SEBELUMNYA ================== --}}
                @if ($laporan->reviews->isNotEmpty())
                    <div class="mb-4">
                        <strong>Review oleh Reviewer:</strong>
                        <ul class="list-group list-group-flush mt-2">
                            @foreach ($laporan->reviews as $review)
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

                {{-- ================== FORM TINDAKAN PRPM ================== --}}
                @php
                    $totalReviewer = $laporan->reviews->count();
                    $approvedCount = $laporan->reviews->where('status', 'approved')->count();
                    $allApproved = $totalReviewer > 0 && $approvedCount === $totalReviewer;
                @endphp

                <div class="mt-4">
                    <h5 class="fw-semibold mb-3 text-success">
                        <i class="bi bi-pencil-square me-2"></i>Perbarui Status Laporan
                    </h5>
                    <form action="{{ route('ketua-prpm.review.penelitian.laporan.update-status', $laporan) }}" method="POST">
                        @csrf
                        <div class="row g-3">

                            {{-- Status --}}
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    @if (!$allApproved)
                                        <option value="">-- Pilih Status --</option>
                                        <option value="menunggu_validasi_reviewer"
                                            {{ $laporan->status == 'menunggu_validasi_reviewer' ? 'selected' : '' }}>
                                            Kirim ke Reviewer
                                        </option>
                                        <option value="revisi" {{ $laporan->status == 'revisi' ? 'selected' : '' }}>
                                            Minta Revisi
                                        </option>
                                        <option value="rejected" {{ $laporan->status == 'rejected' ? 'selected' : '' }}>
                                            Tolak
                                        </option>
                                    @else
                                        <option value="final" selected>Final (semua reviewer sudah approve)</option>
                                    @endif
                                </select>
                            </div>

                            {{-- Assign Reviewer --}}
                            <div class="col-md-6">
                                <label for="reviewer_id" class="form-label fw-semibold">Tugaskan Reviewer</label>
                                <select name="reviewer_id[]" id="reviewer_id" multiple class="form-select"
                                    {{ $allApproved ? 'disabled' : '' }}>
                                    @foreach ($reviewers as $reviewer)
                                        <option value="{{ $reviewer->id }}"
                                            {{ in_array($reviewer->id, $laporan->reviews->pluck('reviewer_id')->toArray()) ? 'selected' : '' }}>
                                            {{ $reviewer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">
                                    {{ $allApproved ? 'Semua reviewer sudah approve, tidak bisa ubah reviewer.' : 'Ketik untuk mencari reviewer dengan cepat.' }}
                                </small>
                            </div>

                            {{-- Komentar PRPM --}}
                            <div class="col-12">
                                <label for="komentar_prpm" class="form-label fw-semibold">Catatan / Komentar</label>
                                <textarea name="komentar_prpm" id="komentar_prpm" class="form-control" rows="3">{{ $laporan->komentar_prpm ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('ketua-prpm.review.penelitian.laporan.index') }}" class="btn btn-secondary me-2">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- ✅ SweetAlert Notifikasi --}}
    @if (session('success') || session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') ?? session('status') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @elseif (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- Init TomSelect ---
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

@endpush

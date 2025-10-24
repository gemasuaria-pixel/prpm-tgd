@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Form Review Laporan Pengabdian</h4>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            @php
                /** @var \App\Models\Pengabdian\LaporanPengabdian $laporan */
                $laporan = $review->reviewable;
                $proposal = $laporan->proposalPengabdian ?? null;
                $ketuaName = optional($proposal->ketuaPengusul)->name ?? '-';
            @endphp

            {{-- ================== INFORMASI LAPORAN & PROPOSAL ================== --}}
            <h5 class="fw-semibold text-primary mb-3">{{ $laporan->judul ?? '-' }}</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Ketua Pengusul:</strong> {{ $ketuaName }}</p>
                    <p><strong>Rumpun Ilmu:</strong> {{ $proposal->rumpun_ilmu ?? '-' }}</p>
                    <p><strong>Bidang Pengabdian:</strong> {{ $proposal->bidang_pengabdian ?? '-' }}</p>
                    <p><strong>Tahun Pelaksanaan:</strong> {{ $proposal->tahun_pelaksanaan ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Kata Kunci:</strong> {{ $laporan->kata_kunci ?? '-' }}</p>
                    <p>
                        <strong>Dokumen Laporan:</strong><br>
                        @if ($laporan->documents && $laporan->documents->count() > 0)
                            @foreach ($laporan->documents as $doc)
                                <a href="{{ asset('storage/' . ($doc->file_path ?? '')) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary mt-1 w-auto">
                                    <i class="bi bi-file-earmark-text me-1"></i> {{ ucfirst($doc->tipe ?? 'Dokumen') }}
                                </a>
                            @endforeach
                        @else
                            <span class="text-muted">Belum ada dokumen laporan</span>
                        @endif
                    </p>
                </div>
            </div>

            {{-- ================== FORM REVIEW ================== --}}
            <form id="reviewForm" method="POST" action="{{ route('reviewer.review.pengabdian.laporan.submit', $review->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="komentar" class="form-label fw-semibold">Komentar Reviewer</label>
                    <textarea name="komentar" id="komentar" class="form-control" rows="5" required>{{ old('komentar', $review->komentar) }}</textarea>
                    @error('komentar')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Status Review</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="approved" {{ old('status', $review->status) == 'approved' ? 'selected' : '' }}>Layak</option>
                        <option value="revisi" {{ old('status', $review->status) == 'revisi' ? 'selected' : '' }}>Revisi</option>
                        <option value="rejected" {{ old('status', $review->status) == 'rejected' ? 'selected' : '' }}>Tidak Layak</option>
                    </select>
                    @error('status')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('reviewer.review.pengabdian.laporan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Simpan Review
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reviewForm = document.getElementById('reviewForm');

        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault(); // hentikan submit default

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Review akan disimpan dan status laporan akan diperbarui.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan review',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    reviewForm.submit(); // submit form jika konfirmasi OK
                }
            });
        });
    });
</script>
@endpush

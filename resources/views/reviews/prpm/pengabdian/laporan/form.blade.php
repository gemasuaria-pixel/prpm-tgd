@extends('layouts.main')

@section('title', 'Detail Laporan Pengabdian')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="container mt-4">

    <h4 class="mb-4">Detail Laporan Pengabdian</h4>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            {{-- ================== INFORMASI LAPORAN ================== --}}
            <h5 class="fw-semibold text-primary mb-3">{{ $laporan->judul ?? '-' }}</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Judul Proposal:</strong> {{ $laporan->proposalPengabdian->judul ?? '-' }}</p>
                    <p><strong>Ketua Pengusul:</strong> {{ $laporan->proposalPengabdian->ketuaPengusul->name ?? '-' }}</p>
                    <p><strong>Status Laporan:</strong>
                        <span class="badge bg-light text-dark">
                            {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tahun Pelaksanaan:</strong> {{ $laporan->proposalPengabdian->tahun_pelaksanaan ?? '-' }}</p>
                    <p><strong>Dokumen Laporan:</strong><br>
                        @if ($laporan->documents->isNotEmpty())
                            @foreach ($laporan->documents as $doc)
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

            {{-- ================== RINGKASAN LAPORAN ================== --}}
            <div class="mb-4">
                <strong>Ringkasan Laporan:</strong>
                <div class="border rounded p-3 bg-light mt-1">
                    {{ $laporan->ringkasan ?? 'Belum ada ringkasan laporan.' }}
                </div>
            </div>

            {{-- ================== MITRA ================== --}}
            <div class="mb-4">
                <strong>Informasi Mitra:</strong>
                <div class="border rounded p-3 bg-light mt-2">
                    <p><strong>Nama Mitra:</strong> {{ $laporan->proposalPengabdian->nama_mitra ?? '-' }}</p>
                    <p><strong>Alamat Mitra:</strong> {{ $laporan->proposalPengabdian->alamat_mitra ?? '-' }}</p>
                    <p><strong>Kontak Mitra:</strong> {{ $laporan->proposalPengabdian->kontak_mitra ?? '-' }}</p>
                    <p><strong>Bentuk Kegiatan:</strong> {{ $laporan->proposalPengabdian->bentuk_kegiatan ?? '-' }}</p>
                </div>
            </div>

            {{-- ================== ANGGOTA DOSEN ================== --}}
            @if ($laporan->proposalPengabdian->anggotaDosen->isNotEmpty())
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
                            @foreach ($laporan->proposalPengabdian->anggotaDosen as $d)
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
            @if ($laporan->proposalPengabdian->anggotaMahasiswa->isNotEmpty())
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
                            @foreach ($laporan->proposalPengabdian->anggotaMahasiswa as $m)
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

            <hr>

            {{-- ================== FORM UPDATE STATUS ================== --}}
            @php
                $totalReviewer = $laporan->reviews->count();
                $approvedCount = $laporan->reviews->where('status', 'approved')->count();
                $allApproved = $totalReviewer > 0 && $approvedCount === $totalReviewer;
            @endphp

            <div class="mt-4">
                <h5 class="fw-semibold mb-3 text-success">
                    <i class="bi bi-pencil-square me-2"></i>Perbarui Status Laporan
                </h5>

                <form id="updateStatusForm" action="{{ route('ketua-prpm.review.pengabdian.laporan.update-status', $laporan->id) }}" method="POST">
                    @csrf
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                @if (!$allApproved)
                                    <option value="">-- Pilih Status --</option>
                                    <option value="menunggu_validasi_reviewer" {{ $laporan->status == 'menunggu_validasi_reviewer' ? 'selected' : '' }}>Kirim ke Reviewer</option>
                                    <option value="revisi" {{ $laporan->status == 'revisi' ? 'selected' : '' }}>Minta Revisi</option>
                                    <option value="rejected" {{ $laporan->status == 'rejected' ? 'selected' : '' }}>Tolak</option>
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
                                        {{ in_array($reviewer->id, $laporan->reviews->pluck('reviewer_id')->toArray()) ? 'selected' : '' }}>
                                        {{ $reviewer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Catatan / Komentar</label>
                            <textarea name="komentar_prpm" class="form-control" rows="3">{{ $laporan->komentar_prpm ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('ketua-prpm.review.pengabdian.laporan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success px-4" id="btnSubmit">
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

<script>
document.addEventListener("DOMContentLoaded", () => {
    new TomSelect("#reviewer_id", {
        plugins: ['remove_button'],
        maxItems: null,
        create: false,
        sortField: { field: "text", direction: "asc" },
        placeholder: "Cari reviewer..."
    });

    const form = document.getElementById("updateStatusForm");

    form.addEventListener("submit", function(e) {
        e.preventDefault();

        const status = document.getElementById("status").value;
        let title = "Apakah Anda yakin?";
        let text = "";
        let icon = "warning";

        switch (status) {
            case "rejected":
                text = "Laporan ini akan ditolak. Tindakan ini tidak dapat dibatalkan.";
                icon = "error";
                break;
            case "menunggu_validasi_reviewer":
                text = "Laporan ini akan dikirim ke reviewer untuk diperiksa.";
                icon = "info";
                break;
            case "final":
                text = "Semua proses akan ditandai selesai dan laporan akan difinalkan.";
                icon = "success";
                break;
            default:
                text = "Perubahan status akan disimpan.";
        }

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonText: "Ya, lanjutkan",
            cancelButtonText: "Batal",
            confirmButtonColor: "#198754",
            cancelButtonColor: "#6c757d",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush

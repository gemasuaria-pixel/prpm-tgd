@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Form Review Proposal Penelitian</h4>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            {{-- ================== INFORMASI PROPOSAL ================== --}}
            @php
                $proposal = $review->reviewable;
            @endphp

            <h5 class="fw-semibold text-primary mb-3">
                {{ $proposal->judul ?? '-' }}
            </h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Ketua Pengusul:</strong> {{ $proposal->ketuaPengusul->name ?? '-' }}</p>
                    <p><strong>Rumpun Ilmu:</strong> {{ $proposal->rumpun_ilmu ?? '-' }}</p>
                    <p><strong>Bidang Penelitian:</strong> {{ $proposal->bidang_penelitian ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tahun Pelaksanaan:</strong> {{ $proposal->tahun_pelaksanaan ?? '-' }}</p>
                    <p><strong>Luaran Tambahan Dijanjikan:</strong> {{ $proposal->luaran_tambahan_dijanjikan ?? '-' }}</p>
                    <p>
                        <strong>Dokumen Proposal:</strong><br>
                        @if ($proposal->documents->count())
                            <a href="{{ asset('storage/' . $proposal->documents->first()->file_path) }}"
                               target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                <i class="bi bi-file-earmark-text me-1"></i> Lihat Dokumen
                            </a>
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

            {{-- ================== ANGGOTA PENELITIAN ================== --}}
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
                            @forelse ($proposal->anggotaDosen ?? [] as $anggota)
                                <tr>
                                    <td>{{ $anggota->user->name ?? '-' }}</td>
                                    <td>{{ $anggota->user->nidn ?? '-' }}</td>
                                    <td>{{ $anggota->user->alamat ?? '-' }}</td>
                                    <td>{{ $anggota->user->kontak ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-2">
                                        Belum ada anggota penelitian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>

            {{-- ================== FORM REVIEW ================== --}}
            <form method="POST" action="{{ route('reviewer.review.penelitian.proposal.submit', $review->id) }}">
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
                        <option value="revision" {{ old('status', $review->status) == 'revision' ? 'selected' : '' }}>Revisi</option>
                        <option value="rejected" {{ old('status', $review->status) == 'rejected' ? 'selected' : '' }}>Tidak Layak</option>
                    </select>
                    @error('status')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('reviewer.review.penelitian.proposal.index') }}" class="btn btn-secondary">
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

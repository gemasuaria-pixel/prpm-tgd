@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Form Review Laporan Penelitian</h4>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            @php
                $laporan = $review->reviewable;
                $proposal = $laporan->proposal ?? null;
            @endphp

            {{-- ================== INFORMASI LAPORAN & PROPOSAL ================== --}}
            <h5 class="fw-semibold text-primary mb-3">{{ $proposal->judul ?? '-' }}</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Ketua Pengusul:</strong> {{ optional($proposal->ketuaPengusul)->name ?? '-' }}</p>
                    <p><strong>Rumpun Ilmu:</strong> {{ $proposal->rumpun_ilmu ?? '-' }}</p>
                    <p><strong>Bidang Penelitian:</strong> {{ optional($proposal->infoPenelitian)->bidang_penelitian ?? '-' }}</p>
                    <p><strong>Tahun Pelaksanaan:</strong> {{ $proposal->tahun_pelaksanaan ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <p><strong>Kata Kunci:</strong> {{ $laporan->kata_kunci ?? '-' }}</p>
                    <p>
                        <strong>Dokumen Laporan:</strong><br>
                        @if ($laporan->documents && $laporan->documents->count() > 0)
                            @foreach ($laporan->documents as $doc)
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
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

            {{-- ================== RINGKASAN ================== --}}
            <div class="mb-4">
                <strong>Ringkasan Hasil Penelitian:</strong>
                <div class="border rounded p-3 bg-light mt-1">
                    {{ $laporan->ringkasan_laporan ?? optional($proposal->infoPenelitian)->abstrak ?? 'Belum ada ringkasan hasil.' }}
                </div>
            </div>

            {{-- ================== LUARAN PENELITIAN ================== --}}
            <div class="mb-4">
                <strong>Luaran Penelitian:</strong>
                <div class="table-responsive mt-2">
                    <table class="table table-sm table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Jenis Luaran</th>
                                <th>Judul Luaran</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporan->luaran ?? [] as $luaran)
                                <tr>
                                    <td>{{ $luaran->jenis_luaran ?? '-' }}</td>
                                    <td>{{ $luaran->judul_luaran ?? '-' }}</td>
                                    <td>{{ $luaran->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-2">
                                        Belum ada data luaran penelitian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                                    <td>{{ $anggota->nama ?? '-' }}</td>
                                    <td>{{ $anggota->nidn ?? '-' }}</td>
                                    <td>{{ $anggota->alamat ?? '-' }}</td>
                                    <td>{{ $anggota->kontak ?? '-' }}</td>
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
            <form method="POST" action="{{ route('reviewer.review-submit', $review->id) }}">
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
                        <option value="layak" {{ old('status', $review->status) == 'layak' ? 'selected' : '' }}>Layak</option>
                        <option value="revisi" {{ old('status', $review->status) == 'revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                        <option value="tidak_layak" {{ old('status', $review->status) == 'tidak_layak' ? 'selected' : '' }}>Tidak Layak</option>
                    </select>
                    @error('status')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('reviewer.index') }}" class="btn btn-secondary">
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

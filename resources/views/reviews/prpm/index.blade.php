@extends('layouts.main')

@section('content')
<main class="app-main">
    <x-breadcrumbs>Review PRPM</x-breadcrumbs>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
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
                                        $statusClass = match ($proposal->status_prpm) {
                                            'approved' => 'bg-success-subtle text-success fw-semibold',
                                            'rejected' => 'bg-danger-subtle text-danger fw-semibold',
                                            'revision' => 'bg-warning-subtle text-warning fw-semibold',
                                            default => 'bg-secondary-subtle text-secondary fw-semibold',
                                        };
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold text-wrap">{{ $proposal->judul }}</td>
                                        <td>{{ $proposal->ketua_pengusul }}</td>
                                        <td>{{ $proposal->rumpun_ilmu ?? '-' }}</td>
                                        <td>
                                            <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                                                {{ ucfirst($proposal->status_prpm ?? 'Menunggu') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-light btn-sm border rounded-pill px-3"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetail{{ $proposal->id }}">
                                                <i class="bi bi-eye text-primary"></i> Detail
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Detail Proposal -->
                                    <div class="modal fade" id="modalDetail{{ $proposal->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title fw-semibold">Detail Proposal</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body bg-light">
                                                    <h5 class="fw-bold mb-4 text-primary">{{ $proposal->judul }}</h5>

                                                    <div class="row mb-4 g-3">
                                                        <div class="col-md-6">
                                                            <div class="p-3 bg-white rounded-3 shadow-sm h-100">
                                                                <p><strong>Ketua Pengusul:</strong> {{ $proposal->ketua_pengusul }}</p>
                                                                <p><strong>Rumpun Ilmu:</strong> {{ $proposal->rumpun_ilmu ?? '-' }}</p>
                                                                <p><strong>Bidang Penelitian:</strong> {{ $proposal->infoPenelitian->bidang_penelitian ?? '-' }}</p>
                                                                <p><strong>Tahun Pelaksanaan:</strong> {{ $proposal->tahun_pelaksanaan }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="p-3 bg-white rounded-3 shadow-sm h-100">
                                                                <p><strong>Kata Kunci:</strong> {{ $proposal->infoPenelitian->kata_kunci ?? '-' }}</p>
                                                                <p><strong>Luaran Tambahan:</strong> {{ $proposal->luaran_tambahan_dijanjikan ?? '-' }}</p>
                                                                <p><strong>Status PRPM:</strong>
                                                                    <span class="badge {{ $statusClass }}">{{ ucfirst($proposal->status_prpm ?? 'Menunggu') }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Abstrak -->
                                                    <div class="card border-0 shadow-sm mb-4">
                                                        <div class="card-body">
                                                            <h6 class="fw-semibold text-primary mb-2">Abstrak</h6>
                                                            <p class="text-muted" style="white-space: pre-line;">
                                                                {{ $proposal->infoPenelitian->abstrak ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <!-- Dokumen -->
                                                    <div class="card border-0 shadow-sm mb-4">
                                                        <div class="card-body">
                                                            <h6 class="fw-semibold text-primary mb-2">Dokumen Proposal</h6>
                                                            @if ($proposal->documents->isNotEmpty())
                                                                @foreach ($proposal->documents as $doc)
                                                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                                                        class="btn btn-outline-secondary btn-sm rounded-pill me-2 mb-2">
                                                                        <i class="bi bi-file-earmark-text"></i> {{ ucfirst($doc->tipe) }}
                                                                    </a>
                                                                @endforeach
                                                            @else
                                                                <em class="text-muted">Belum diunggah</em>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Anggota -->
                                                    @if ($proposal->members->isNotEmpty())
                                                        <div class="card border-0 shadow-sm mb-4">
                                                            <div class="card-body">
                                                                <h6 class="fw-semibold text-primary mb-2">Anggota Penelitian</h6>
                                                                <div class="list-group list-group-flush">
                                                                    @foreach ($proposal->members as $member)
                                                                        <div class="list-group-item">
                                                                            <strong>{{ $member->nama }}</strong><br>
                                                                            <small class="text-muted">NIDN: {{ $member->nidn ?? '-' }}</small><br>
                                                                            <small class="text-muted">Alamat: {{ $member->alamat ?? '-' }}</small><br>
                                                                            <small class="text-muted">Kontak: {{ $member->kontak ?? '-' }}</small>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- Update Status -->
                                                    <div class="card border-0 shadow-sm">
                                                        <div class="card-body">
                                                            <h6 class="fw-semibold text-primary mb-3">Tinjau & Perbarui Status</h6>
                                                            <form action="{{ route('ketua-prpm.prpm.review.updateStatus', $proposal->id) }}" method="POST">
                                                                @csrf
                                                                <div class="row g-3">
                                                                    <div class="col-md-6">
                                                                        <label class="form-label fw-semibold">Status PRPM</label>
                                                                        <select name="status_prpm" class="form-select form-select-sm" required>
                                                                            <option value="">Pilih Status</option>
                                                                            <option value="approved" {{ $proposal->status_prpm == 'approved' ? 'selected' : '' }}>Setujui & Tugaskan Reviewer</option>
                                                                            <option value="rejected" {{ $proposal->status_prpm == 'rejected' ? 'selected' : '' }}>Tolak</option>
                                                                            <option value="revision" {{ $proposal->status_prpm == 'revision' ? 'selected' : '' }}>Minta Revisi</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label class="form-label fw-semibold">Tugaskan Reviewer</label>
                                                                        <select name="reviewer_id[]" class="form-select form-select-sm" multiple>
                                                                            @foreach ($reviewers as $reviewer)
                                                                                <option value="{{ $reviewer->id }}">{{ $reviewer->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <small class="text-muted">Tekan Ctrl/Cmd untuk memilih lebih dari satu.</small>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <label class="form-label fw-semibold">Catatan PRPM</label>
                                                                        <textarea name="komentar_prpm" class="form-control" rows="3" placeholder="Catatan (opsional)">{{ $proposal->komentar_prpm ?? '' }}</textarea>
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
                                        <td colspan="5" class="text-center py-4 text-muted">Tidak ada usulan yang menunggu persetujuan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@extends('layouts.main')

@section('content')
<main class="app-main">
    <x-breadcrumbs>Status Penelitian</x-breadcrumbs>
    <div class="app-content">
        <div class="container-fluid">
            <h4 class="mb-4">Daftar Usulan Menunggu Persetujuan</h4>

            <div class="table-responsive shadow-sm rounded-3">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Judul</th>
                            <th>Ketua Pengusul</th>
                            <th>Rumpun Ilmu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proposals as $proposal)
                            @php
                                $statusClass = match ($proposal->status_prpm) {
                                    'approved' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                    'revision' => 'bg-warning',
                                    'review' => 'bg-info',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <tr>
                                <td>{{ $proposal->judul_penelitian }}</td>
                                <td>{{ $proposal->ketua_pengusul }}</td>
                                <td>{{ $proposal->rumpun_ilmu }}</td>
                                <td>
                                    <span class="badge {{ $statusClass }}">
                                        {{ ucfirst($proposal->status_prpm ?? 'Menunggu') }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalDetail{{ $proposal->id }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Detail Proposal -->
                            <div class="modal fade" id="modalDetail{{ $proposal->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Detail Proposal Penelitian</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <h5 class="fw-bold mb-3">{{ $proposal->judul_penelitian }}</h5>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <p><strong>Ketua Pengusul:</strong> {{ $proposal->ketua_pengusul }}</p>
                                                    <p><strong>Rumpun Ilmu:</strong> {{ $proposal->rumpun_ilmu }}</p>
                                                    <p><strong>Bidang Penelitian:</strong> {{ $proposal->bidang_penelitian ?? '-' }}</p>
                                                    <p><strong>Tahun Pelaksanaan:</strong> {{ $proposal->tahun_pelaksanaan }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Kata Kunci:</strong> {{ $proposal->kata_kunci }}</p>
                                                    <p><strong>Luaran Tambahan:</strong> {{ $proposal->luaran_tambahan ?? '-' }}</p>
                                                    <p><strong>Status PRPM:</strong>
                                                        <span class="badge {{ $statusClass }}">{{ ucfirst($proposal->status_prpm) }}</span>
                                                    </p>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="mb-4">
                                                <h6 class="fw-semibold">Abstrak</h6>
                                                <p class="text-muted" style="white-space: pre-line;">
                                                    {{ $proposal->abstrak }}
                                                </p>
                                            </div>

                                            <hr>

                                            <div class="mb-4">
                                                <h6 class="fw-semibold">Dokumen Proposal</h6>
                                                @if ($proposal->dokumen->isNotEmpty())
                                                    @foreach ($proposal->dokumen as $doc)
                                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                                            class="text-decoration-none d-block mb-2">
                                                            📄 Download {{ ucfirst($doc->jenis_dokumen) }}
                                                        </a>
                                                    @endforeach
                                                @else
                                                    <em>Belum diunggah</em>
                                                @endif
                                            </div>

                                            <hr>

                                            @if ($proposal->anggota->isNotEmpty())
                                                <div class="mb-4">
                                                    <h6 class="fw-semibold">Anggota Penelitian</h6>
                                                    <ul class="list-group list-group-flush">
                                                        @foreach ($proposal->anggota as $member)
                                                            <li class="list-group-item">
                                                                <strong>{{ $member->nama }}</strong><br>
                                                                <small>NIDN: {{ $member->nidn ?? '-' }}</small><br>
                                                                <small>Alamat: {{ $member->alamat ?? '-' }}</small><br>
                                                                <small>Kontak: {{ $member->kontak ?? '-' }}</small>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <hr>

                                            <!-- Form Update Status -->
                                            <form action="{{ route('prpm.review.updateStatus', $proposal->id) }}" method="POST">
                                                @csrf
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Status PRPM</label>
                                                        <select name="status_prpm" class="form-select form-select-sm" required>
                                                            <option value="">Pilih Status</option>
                                                            <option value="approved" {{ $proposal->status_prpm == 'approved' ? 'selected' : '' }}>
                                                                Setujui & Tugaskan Reviewer
                                                            </option>
                                                            <option value="rejected" {{ $proposal->status_prpm == 'rejected' ? 'selected' : '' }}>
                                                                Tolak
                                                            </option>
                                                            <option value="revision" {{ $proposal->status_prpm == 'revision' ? 'selected' : '' }}>
                                                                Minta Revisi
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Tugaskan Reviewer</label>
                                                        <select name="reviewer_id[]" class="form-select form-select-sm" multiple>
                                                            @foreach ($reviewers as $reviewer)
                                                                <option value="{{ $reviewer->id }}">
                                                                    {{ $reviewer->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="text-muted">Tekan Ctrl (Windows) / Cmd (Mac) untuk memilih lebih dari satu.</small>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold">Catatan PRPM</label>
                                                        <textarea name="komentar_prpm" class="form-control" rows="3" placeholder="Catatan (opsional)">{{ $proposal->komentar_prpm }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="mt-4 text-end">
                                                    <button type="submit" class="btn btn-primary px-4">
                                                        <i class="bi bi-save"></i> Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

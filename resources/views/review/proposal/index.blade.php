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
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proposals as $proposal)
                            @php
                                $statusClass = match($proposal->status_prpm) {
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
                                <td>{{ ucfirst($proposal->jenis) }}</td>
                                <td>
                                    <span class="badge {{ $statusClass }}">{{ ucfirst($proposal->status_prpm ?? 'Menunggu') }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDetail{{ $proposal->id }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Detail Proposal -->
                            <div class="modal fade" id="modalDetail{{ $proposal->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Detail Proposal</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="fw-bold">{{ $proposal->judul_penelitian }}</h5>
                                            <p class="text-muted mb-3">
                                                <strong>Ketua:</strong> {{ $proposal->ketua_pengusul }} <br>
                                                <strong>Rumpun Ilmu:</strong> {{ $proposal->rumpun_ilmu }} <br>
                                                <strong>Bidang:</strong> {{ $proposal->bidang_penelitian }} <br>
                                                <strong>Lokasi:</strong> {{ $proposal->lokasi ?? '-' }}
                                            </p>
                                            <p><strong>Abstrak:</strong> {{ $proposal->abstrak }}</p>
                                            <p><strong>Luaran Tambahan:</strong> {{ $proposal->luaran_tambahan ?? '-' }}</p>
                                            <p><strong>File Proposal:</strong> 
                                                @if($proposal->file_path)
                                                    <a href="{{ asset('storage/' . $proposal->file_path) }}" target="_blank" class="text-decoration-none">
                                                        📄 Download
                                                    </a>
                                                @else
                                                    <em>Belum diunggah</em>
                                                @endif
                                            </p>

                                            <hr>

                                            <form action="{{ route('review.update', $proposal->id) }}" method="POST">
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
                                                        <select name="reviewer_id" class="form-select form-select-sm">
                                                            <option value="">Pilih Reviewer</option>
                                                            @foreach ($reviewers as $reviewer)
                                                                <option value="{{ $reviewer->id }}">{{ $reviewer->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold">Catatan PRPM</label>
                                                        <textarea name="komentar_prpm" class="form-control" rows="3" placeholder="Catatan (opsional)">{{ $proposal->komentar_prpm }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="mt-4 text-end">
                                                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
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

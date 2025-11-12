@extends('layouts.main')
@section('content')
    <!--begin::App Main-->
    <main class="app-main">
        <x-breadcrumbs>Status Penelitian</x-breadcrumbs>
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->

            <body>

                <div class="container-fluid py-4">
                    <!--begin::Row-->

                    <!--begin::Row-->
                    <div class="row g-4">

                        <div class="col-md-4 col-sm-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body text-center">
                                    <div
                                        class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-3 p-3 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#0d6efd" viewBox="0 0 24 24"
                                            width="28" height="28">
                                            <path d="M3 4h18v2H3zm0 6h18v2H3zm0 6h18v2H3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold text-primary mb-1">{{ $proposalCount['total'] }}</h3>
                                        <p class="text-secondary small mb-0">Total Proposal Aktif</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body text-center">
                                    <div
                                        class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-3 p-3 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#198754" viewBox="0 0 640 640"
                                            width="28" height="28">
                                            <path
                                                d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM404.4 276.7L324.4 404.7C320.2 411.4 313 415.6 305.1 416C297.2 416.4 289.6 412.8 284.9 406.4L236.9 342.4C228.9 331.8 231.1 316.8 241.7 308.8C252.3 300.8 267.3 303 275.3 313.6L302.3 349.6L363.7 251.3C370.7 240.1 385.5 236.6 396.8 243.7C408.1 250.8 411.5 265.5 404.4 276.8z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold text-success mb-1">{{ $proposalCount['diterima'] }}</h3>
                                        <p class="text-secondary small mb-0">Proposal Diterima</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body text-center">
                                    <div
                                        class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 rounded-3 p-3 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#0dcaf0" viewBox="0 0 640 640"
                                            width="28" height="28">
                                            <path
                                                d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM404.4 276.7L324.4 404.7C320.2 411.4 313 415.6 305.1 416C297.2 416.4 289.6 412.8 284.9 406.4L236.9 342.4C228.9 331.8 231.1 316.8 241.7 308.8C252.3 300.8 267.3 303 275.3 313.6L302.3 349.6L363.7 251.3C370.7 240.1 385.5 236.6 396.8 243.7C408.1 250.8 411.5 265.5 404.4 276.8z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold text-info mb-1">{{ $reportCount['diterima'] }}</h3>
                                        <p class="text-secondary small mb-0">Laporan Diterima</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>







                    <!--end::Row-->
                    <div class="row my-4">
                        <div class="col-md-6 d-grid ">
                            @if ($isProfileComplete)
                                <a href="{{ route('dosen.penelitian.proposal.create') }}"
                                    class="btn btn-outline-primary btn-lg rounded-3 fw-semibold shadow-sm">
                                    <i class="bi bi-plus-circle me-2"></i> Usulan Penelitian
                                </a>
                            @else
                                <button class="btn btn-outline-secondary btn-lg rounded-3 fw-semibold shadow-sm" disabled
                                    title="Lengkapi profil Anda terlebih dahulu">
                                    <i class="bi bi-plus-circle me-2"></i> Usulan Penelitian
                                </button>
                            @endif
                        </div>

                        <div class="col-md-6 d-grid">
                            @if ($proposalFinals->isNotEmpty())
                                <!-- Tombol untuk buka modal -->
                                <button type="button"
                                    class="btn btn-outline-success btn-lg rounded-3 fw-semibold shadow-sm"
                                    data-bs-toggle="modal" data-bs-target="#pilihProposalModal">
                                    <i class="bi bi-file-earmark-text me-2"></i> Laporan Penelitian
                                </button>
                            @else
                                <button class="btn btn-secondary btn-lg rounded-3 fw-semibold shadow-sm" disabled>
                                    <i class="bi bi-file-earmark-text me-2"></i> Laporan Penelitian
                                </button>
                            @endif
                        </div>

                    </div>


                    <!-- =============================== -->
                    <!-- MODAL PILIH PROPOSAL -->
                    <!-- =============================== -->
                    <div class="modal fade" id="pilihProposalModal" tabindex="-1" aria-labelledby="pilihProposalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg">

                                <div class="modal-header bg-light border-bottom">
                                    <h5 class="modal-title fw-semibold" id="pilihProposalLabel">
                                        <i class="bi bi-file-earmark-text me-2 text-success"></i>
                                        Pilih Proposal untuk Upload Laporan
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    @forelse ($proposalFinals as $proposal)
                                        @php
                                            // Buat identifier alami yang bisa dibaca manusia
                                            $identifier =
                                                '#' .
                                                now()->year .
                                                '-' .
                                                strtoupper(substr($proposal->jenis ?? 'PNL', 0, 3)) .
                                                '-' .
                                                str_pad($proposal->id, 3, '0', STR_PAD_LEFT);
                                        @endphp

                                        <div
                                            class="d-flex justify-content-between align-items-center border rounded-3 p-3 mb-2 shadow-sm hover-shadow-sm">
                                            <div class="flex-grow-1 me-3">
                                                <h6 class="fw-bold mb-1">{{ $proposal->judul }}</h6>
                                                <small class="text-muted d-block">
                                                    {{ ucfirst($proposal->jenis ?? 'Penelitian') }} — Diterima
                                                    {{ $proposal->updated_at->translatedFormat('d F Y') }}
                                                </small>
                                                <small class="text-muted">ID: {{ $identifier }}</small>
                                            </div>

                                            <a href="{{ route('dosen.penelitian.laporan.create', ['proposalId' => $proposal->id]) }}"
                                                class="btn btn-outline-success btn-sm fw-semibold">
                                                <i class="bi bi-upload me-1"></i> Upload
                                            </a>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted py-4">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Belum ada proposal diterima untuk dilaporkan.
                                        </div>
                                    @endforelse
                                </div>

                                <div class="modal-footer bg-light border-top">
                                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">
                                        Tutup
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Status Penelitian</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-md">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Upload</th>
                                            <th>Judul</th>
                                            <th>Jenis</th>
                                            <th>Status</th>
                                            <th>Tanggal Update</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($allEntries as $entry)
                                            <tr>
                                                {{-- Tanggal Upload --}}
                                                <td>{{ $entry->tanggal_upload->format('d-m-Y H:i') }}</td>

                                                {{-- Judul --}}
                                                <td>{{ Str::limit($entry->judul, 30, '...') ?? '-' }}</td>

                                                {{-- Jenis Dokumen --}}
                                                <td>
                                                    @if ($entry->jenis === 'Proposal')
                                                        <span class="badge text-bg-primary">{{ $entry->jenis }}</span>
                                                    @else
                                                        <span class="badge text-bg-success">{{ $entry->jenis }}</span>
                                                    @endif
                                                </td>

                                                {{-- Status --}}
                                                <td>
                                                    @php
                                                        $statusClass = match ($entry->status) {
                                                            'final' => 'text-bg-success',
                                                            'menunggu_validasi_prpm' => 'text-bg-warning',
                                                            'rejected' => 'text-bg-danger',
                                                            default => 'text-bg-secondary',
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $statusClass }}">
                                                        {{ ucfirst(str_replace('_', ' ', $entry->status)) }}
                                                    </span>
                                                </td>

                                                {{-- Tanggal Update --}}
                                                <td>{{ $entry->tanggal_update->format('d-m-Y H:i') }}</td>

                                                {{-- Link External --}}

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">
                                                    Belum ada data penelitian
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Optional: Pagination Static (nanti bisa diganti pagination real kalau pakai paginate()) --}}
                        <div class="card-footer clearfix">
                            <div class="float-end">
                                {{ $allEntries->links() }}
                            </div>
                        </div>

                    </div>











                </div>
                <!--end::Container-->
        </div>


        <!--end::App Content-->
    </main>
@endsection

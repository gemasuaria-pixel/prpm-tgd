@extends('layouts.main')

@section('content')
<main class="app-main">
    <x-breadcrumbs>Review PRPM - Laporan Pengabdian</x-breadcrumbs>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">

                    {{-- Tabs --}}
                    <ul class="nav nav-tabs mt-3 px-3" id="reviewTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('ketua-prpm.review.pengabdian.proposal.index') }}"
                                class="nav-link {{ request()->routeIs('ketua-prpm.review.pengabdian.proposal.index') ? 'active' : '' }}">
                                Proposal Pengabdian
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('ketua-prpm.review.pengabdian.laporan.index') }}"
                                class="nav-link {{ request()->routeIs('ketua-prpm.review.pengabdian.laporan.index') ? 'active' : '' }}">
                                Laporan Pengabdian
                            </a>
                        </li>
                    </ul>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul</th>
                                    <th>Ketua Pengusul</th>
                                    <th>Nama Mitra</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporans as $laporan)
                                    @php
                                        [$statusClass, $statusIcon, $statusLabel] = match ($laporan->status) {
                                            'menunggu_validasi_reviewer' => ['bg-warning text-dark', 'bi-hourglass', 'Menunggu Reviewer'],
                                            'menunggu_validasi_prpm' => ['bg-warning text-dark', 'bi-hourglass', 'Menunggu PRPM'],
                                            'approved_by_reviewer' => ['bg-success text-white', 'bi-check-circle', 'Disetujui Reviewer'],
                                            'revisi' => ['bg-warning text-dark', 'bi-arrow-repeat', 'Perlu Revisi'],
                                            'rejected' => ['bg-danger text-white', 'bi-x-circle', 'Ditolak'],
                                            'final' => ['bg-primary text-white', 'bi-flag', 'Final'],
                                            default => ['bg-secondary text-white', 'bi-question-circle', ucfirst($laporan->status)]
                                        };
                                    @endphp

                                    <tr>
                                        <td class="fw-semibold text-wrap">{{ Str::limit($laporan->judul, 30, '...') ?? '-' }}</td>
                                        <td>{{ Str::limit($laporan->proposalPengabdian->ketuaPengusul->name ?? '-', 30, '...') }}</td>
                                        <td>{{ Str::limit($laporan->proposalPengabdian->nama_mitra ?? '-', 30, '...') }}</td>
                                        <td>
                                            <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                                                <i class="bi {{ $statusIcon }} me-1"></i>
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('ketua-prpm.review.pengabdian.laporan.form', $laporan->id) }}"
                                                class="btn btn-light btn-sm borders rounded-pill px-3">
                                                <i class="bi bi-pencil-square text-primary"></i> Review
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Tidak ada laporan pengabdian yang menunggu persetujuan.
                                        </td>
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

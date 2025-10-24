@extends('layouts.main')

@section('content')
<main class="app-main">
    <x-breadcrumbs>Review PRPM</x-breadcrumbs>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">

                    {{-- ✅ Nav Tabs Navigasi Antar Halaman --}}
                    <ul class="nav nav-tabs mt-3 px-3" id="reviewTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('reviewer.proposal.index') }}"
                                class="nav-link {{ request()->routeIs('reviewer.proposal.index') ? 'active' : '' }}">
                                Proposal Pengabdian
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('reviewer.laporan.index') }}"
                                class="nav-link {{ request()->routeIs('reviewer.laporan.index') ? 'active' : '' }}">
                                Laporan Pengabdian
                            </a>
                        </li>
                    </ul>

                    {{-- ✅ Tabel List Laporan --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul</th>
                                    <th>Ketua Pengusul</th>
                                    <th>Status Review</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporanReviews as $review)
                                    @php
                                        $laporan = $review->reviewable;
                                        $proposal = $laporan->proposalPengabdian ?? null;

                                        $statusClass = match ($review->status) {
                                            'approved' => 'bg-success-subtle text-success fw-semibold',
                                            'revision' => 'bg-warning-subtle text-warning fw-semibold',
                                            'rejected' => 'bg-danger-subtle text-danger fw-semibold',
                                            'pending' => 'bg-secondary-subtle text-secondary fw-semibold',
                                            default => 'bg-secondary-subtle text-secondary fw-semibold',
                                        };
                                    @endphp

                                    <tr>
                                        <td class="fw-semibold text-wrap">
                                            {{ Str::limit($laporan->judul, 30, '...')?? '-' }}
                                        </td>
                                        <td>
                                            {{ $proposal->ketuaPengusul->name ?? '-' }}
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                                                {{ ucfirst($review->status ?? 'Menunggu') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('reviewer.laporan.form', $review->id) }}"
                                                class="btn btn-light btn-sm border rounded-pill px-3">
                                                <i class="bi bi-pencil-square text-primary"></i> Review
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            Tidak ada laporan yang menunggu review.
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

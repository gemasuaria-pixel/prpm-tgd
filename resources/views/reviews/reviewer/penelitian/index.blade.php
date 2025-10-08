@extends('layouts.main')

@section('content')
    <main class="app-main">
        <x-breadcrumbs>Review Reviewer</x-breadcrumbs>

        <div class="app-content">
            <div class="container-fluid">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-0">
                        {{-- ================== NAV TABS ================== --}}
                        <ul class="nav nav-tabs mt-3 px-3" id="reviewTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="proposal-tab" data-bs-toggle="tab"
                                    data-bs-target="#proposal" type="button" role="tab">
                                    Proposal Penelitian
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="laporan-tab" data-bs-toggle="tab" data-bs-target="#laporan"
                                    type="button" role="tab">
                                    Laporan Penelitian
                                </button>
                            </li>
                        </ul>

                        {{-- ================== TAB CONTENT ================== --}}
                        <div class="tab-content mt-4 p-3" id="reviewTabsContent">
                            {{-- ===== TAB PROPOSAL ===== --}}
                            <div class="tab-pane fade show active" id="proposal" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">Judul Proposal</th>
                                                <th>Kategori</th>
                                                <th>Bidang & Rumpun</th>
                                                <th>Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($proposalReviews as $review)
                                                @php
                                                    $proposal = $review->reviewable;
                                                    $statusClass = match ($review->status) {
                                                        'pending' => 'bg-warning text-dark',
                                                        'approved' => 'bg-success text-white',
                                                        'revision' => 'bg-info text-dark',
                                                        'rejected' => 'bg-danger text-white',
                                                        default => 'bg-secondary text-white',
                                                    };
                                                @endphp
                                                <tr class="border-bottom">
                                                    <td class="ps-4">
                                                        <div class="fw-semibold text-dark">
                                                            {{ $proposal->judul ?? '-' }}
                                                        </div>
                                                        <div class="text-muted small">
                                                            Ketua: {{ $proposal->ketua_pengusul ?? '-' }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary-subtle text-primary fw-semibold">
                                                            Proposal Penelitian
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium">
                                                            {{ $proposal->infoPenelitian->bidang_penelitian ?? '-' }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                                                            {{ ucfirst($review->status ?? 'Menunggu') }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('reviewer.review-proposal', $review->id) }}"
                                                            class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                            <i class="bi bi-pencil-square me-1"></i> Review
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">
                                                        Tidak ada proposal yang menunggu review.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- ===== TAB LAPORAN ===== --}}
                            <div class="tab-pane fade" id="laporan" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">Judul Laporan</th>
                                                <th>Kategori</th>
                                                <th>Bidang & Rumpun</th>
                                                <th>Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($laporanReviews as $review)
                                                @php
                                                    $laporan = $review->reviewable;
                                                    $statusClass = match ($review->status) {
                                                        'pending' => 'bg-warning text-dark',
                                                        'approved' => 'bg-success text-white',
                                                        'revision' => 'bg-info text-dark',
                                                        'rejected' => 'bg-danger text-white',
                                                        default => 'bg-secondary text-white',
                                                    };
                                                @endphp
                                                <tr class="border-bottom">
                                                    <td class="ps-4">
                                                        <div class="fw-semibold text-dark">
                                                            {{ $laporan->proposal->judul ?? '-' }}
                                                        </div>
                                                        <div class="text-muted small">
                                                            Ketua: {{ $laporan->proposal->ketua_pengusul ?? '-' }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success-subtle text-success fw-semibold">
                                                            Laporan Penelitian
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium">
                                                            {{ $laporan->proposal->infoPenelitian->bidang_penelitian ?? '-' }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                                                            {{ ucfirst($review->status ?? 'Menunggu') }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $routeName =
                                                                $review->reviewable_type ===
                                                                App\Models\Proposal\Proposal::class
                                                                    ? 'reviewer.review-proposal'
                                                                    : 'reviewer.review-laporan';
                                                        @endphp

                                                        <a href="{{ route($routeName, $review->id) }}"
                                                            class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                            <i class="bi bi-pencil-square me-1"></i> Review
                                                        </a>
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">
                                                        Tidak ada laporan yang menunggu review.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> {{-- end tab-content --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

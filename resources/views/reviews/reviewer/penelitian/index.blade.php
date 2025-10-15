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
                    <div class="tab-content mt-4 p-4" id="reviewTabsContent">

                        {{-- ===== TAB PROPOSAL ===== --}}
                        <div class="tab-pane fade show active" id="proposal" role="tabpanel">
                            <div class="card border-0 shadow-sm rounded-4 mb-4">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="ps-4">Judul</th>
                                                    <th>Ketua Pengusul</th>
                                                    <th>Kategori</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($proposalReviews as $review)
                                                    @php
                                                        $proposal = $review->reviewable;
                                                        $statusClass = match ($review->status) {
                                                            'layak', 'approved' => 'bg-success-subtle text-success fw-semibold',
                                                            'revisi', 'revision' => 'bg-warning-subtle text-warning fw-semibold',
                                                            'tidak_layak', 'rejected' => 'bg-danger-subtle text-danger fw-semibold',
                                                            'pending' => 'bg-secondary-subtle text-secondary fw-semibold',
                                                            default => 'bg-secondary-subtle text-secondary fw-semibold',
                                                        };
                                                    @endphp
                                                    <tr>
                                                        <td class="ps-4 fw-semibold text-wrap">
                                                            {{ $proposal->judul ?? '-' }}
                                                        </td>
                                                        <td>{{ $proposal->ketuaPengusul->name ?? '-' }}</td>
                                                        <td>
                                                            <span class="badge bg-primary-subtle text-primary fw-semibold">
                                                                Proposal Penelitian
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                                                                {{ ucfirst(str_replace('_', ' ', $review->status ?? 'Menunggu')) }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('reviewer.review-proposal', $review->id) }}"
                                                                class="btn btn-light btn-sm border rounded-pill px-3">
                                                                <i class="bi bi-pencil-square text-primary"></i> Review
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
                            </div>
                        </div>


                        {{-- ===== TAB LAPORAN ===== --}}
                        <div class="tab-pane fade" id="laporan" role="tabpanel">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="ps-4">Judul</th>
                                                    <th>Ketua Pengusul</th>
                                                    <th>Kategori</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($laporanReviews as $review)
                                                    @php
                                                        $laporan = $review->reviewable;
                                                        $statusClass = match ($review->status) {
                                                            'approved' => 'bg-success-subtle text-success fw-semibold',
                                                            'revision' => 'bg-warning-subtle text-warning fw-semibold',
                                                            'rejected' => 'bg-danger-subtle text-danger fw-semibold',
                                                            'pending' => 'bg-secondary-subtle text-secondary fw-semibold',
                                                            default => 'bg-secondary-subtle text-secondary fw-semibold',
                                                        };
                                                    @endphp
                                                    <tr>
                                                        <td class="ps-4 fw-semibold text-wrap">
                                                            {{ $laporan->proposal->judul ?? '-' }}
                                                        </td>
                                                        <td>{{ $laporan->proposal->ketua_pengusul ?? '-' }}</td>
                                                        <td>
                                                            <span class="badge bg-success-subtle text-success fw-semibold">
                                                                Laporan Penelitian
                                                            </span>
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
                                                                class="btn btn-light btn-sm border rounded-pill px-3">
                                                                <i class="bi bi-pencil-square text-primary"></i> Review
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
                            </div>
                        </div>

                    </div> {{-- end tab-content --}}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

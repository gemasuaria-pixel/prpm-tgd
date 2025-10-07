@extends('layouts.main')

@section('content')
<main class="app-main">
    <div class="app-content">
        <x-breadcrumbs>Review Proposal</x-breadcrumbs>

        <div class="container py-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
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
                                @forelse ($reviews as $review)
                                    @php
                                        $proposal = $review->reviewable;
                                        $info = $proposal->infoPenelitian ?? null;

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
                                                {{ ucfirst($proposal->jenis ?? '-') }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="fw-medium">
                                                {{ $info->bidang_penelitian ?? '-' }}
                                            </div>
                                    
                                        </td>

                                        <td>
                                            <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                                                {{ ucfirst($review->status ?? 'Menunggu') }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('reviewer.review-form', $review->id) }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                <i class="bi bi-pencil-square me-1"></i> Review
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Tidak ada proposal yang menunggu review saat ini.
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

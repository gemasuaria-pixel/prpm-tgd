@props(['entries'])

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
            @forelse ($entries as $entry)
                @php
                    [$statusClass, $statusIcon, $statusLabel] = match ($entry->status) {
                        'menunggu_validasi_reviewer' => ['bg-warning text-dark', 'bi-hourglass', 'Menunggu Reviewer'],
                        'menunggu_validasi_prpm' => ['bg-warning text-dark', 'bi-hourglass', 'Menunggu PRPM'],
                        'approved_by_reviewer' => ['bg-success text-white', 'bi-check-circle', 'Disetujui Reviewer'],
                        'revisi' => ['bg-warning text-dark', 'bi-arrow-repeat', 'Perlu Revisi'],
                        'rejected' => ['bg-danger text-white', 'bi-x-circle', 'Ditolak'],
                        'final' => ['bg-primary text-white', 'bi-flag', 'Final'],
                        default => ['bg-secondary text-white', 'bi-question-circle', 'Tidak Diketahui'],
                    };
                @endphp

                <tr>
                    <td class="fw-semibold text-wrap">
                        {{ Str::limit($entry->judul, 30, '...') ?? '-' }}
                    </td>
                    <td>{{ Str::limit($entry->ketuaPengusul->name, 30, '...') ?? '-' }}</td>
                    <td>{{ $entry->rumpunIlmu ?? '-' }}</td>
                    <td>
                        <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                            <i class="bi {{ $statusIcon }} me-1"></i>{{ $statusLabel }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ $entry->reviewRoute }}" class="btn btn-light btn-sm borders rounded-pill px-3">
                            <i class="bi bi-pencil-square text-primary"></i> Review
                        </a>

                    </td>z
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        Tidak ada data yang menunggu persetujuan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

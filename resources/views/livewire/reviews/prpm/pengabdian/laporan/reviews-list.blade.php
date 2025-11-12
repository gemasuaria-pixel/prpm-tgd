<div>
    {{-- 🔹 Navigasi Tab --}}
    <ul class="nav nav-tabs mt-3 px-3">
        <li class="nav-item">
            <a href="{{ route('ketua-prpm.review.pengabdian.proposal.index') }}" wire:navigate
                class="nav-link {{ request()->routeIs('ketua-prpm.review.pengabdian.proposal.index') ? 'active' : '' }}">
                Proposal
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('ketua-prpm.review.pengabdian.laporan.index') }}" wire:navigate
                class="nav-link {{ request()->routeIs('ketua-prpm.review.pengabdian.laporan.index') ? 'active' : '' }}">
                Laporan
            </a>
        </li>
    </ul>

    {{-- 🔍 Filter --}}
    <div class="container-fluid px-3 py-3">
        <div class="row g-4 align-items-center">

            {{-- Kolom Input Pencarian --}}
            <div class="col-12 col-md-8 position-relative">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input wire:model.live.debounce.500ms="search" type="text"
                    class="form-control ps-5 py-2 rounded-pill shadow-sm border-0"
                    placeholder="Cari judul, ketua pengusul, atau rumpun ilmu..." style="background-color: #f8f9fa;">
            </div>

            {{-- Kolom Dropdown Filter --}}
            <div class="col-12 col-md-3 position-relative ms-md-auto">
                <i class="bi bi-filter position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <select wire:model.live.debounce.500ms="status"
                    class="form-select ps-5 py-2 rounded-pill shadow-sm border-0" style="background-color: #f8f9fa;">
                    <option value="">Semua Status</option>
                    <option value="menunggu_validasi_reviewer">Menunggu Reviewer</option>
                    <option value="menunggu_validasi_prpm">Menunggu PRPM</option>
                    <option value="approved_by_reviewer">Disetujui Reviewer</option>
                    <option value="revisi">Revisi</option>
                    <option value="rejected">Ditolak</option>
                    <option value="final">Final</option>
                </select>
            </div>

        </div>
    </div>

    {{-- 🔹 Table --}}
    <table class="table table-hover table-sm align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Ketua Pengusul</th>
                <th>Rumpun Ilmu</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $index => $entry)
                <tr wire:key="laporan-{{ $entry->id }}">
                    <td>{{ $index + $laporans->firstItem() }}</td>
                    <td>{{ Str::limit($entry->judul, 40) }}</td>
                    <td>{{ $entry->proposalPengabdian->ketuaPengusul->name ?? '-' }}</td>
                    <td>{{ $entry->proposalPengabdian->rumpun_ilmu ?? '-' }}</td>
                    <td>
                        @php
                            [$class, $label] = match ($entry->status) {
                                'menunggu_validasi_reviewer' => ['text-bg-warning', 'Menunggu Reviewer'],
                                'menunggu_validasi_prpm' => ['text-bg-warning', 'Menunggu PRPM'],
                                'approved_by_reviewer' => ['text-bg-success', 'Disetujui Reviewer'],
                                'revisi' => ['text-bg-warning', 'Perlu Revisi'],
                                'rejected' => ['text-bg-danger', 'Ditolak'],
                                'final' => ['text-bg-primary', 'Final'],
                                default => ['text-bg-secondary', ucfirst($entry->status ?? '-')],
                            };
                        @endphp
                        <span class="badge {{ $class }}">{{ $label }}</span>
                    </td>
                    <td class="text-center">
                        <a wire:navigate
                            href="{{ route('ketua-prpm.review.pengabdian.laporan.form', ['laporanId' => $entry->id]) }}"
                            class="btn btn-outline-primary btn-sm rounded-3 d-inline-flex align-items-center gap-1 px-2">
                            <span>Review</span>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Tidak ada data ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="card-footer">
        {{ $laporans->links(data: ['wire:navigate' => true]) }}
    </div>
</div>

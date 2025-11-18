<div>
    {{-- 🔹 Navigasi Tab --}}
    <ul class="nav nav-tabs mt-3 px-3">
        <li class="nav-item">
            <a href="{{ route('reviewer.review.pengabdian.proposal.index') }}" wire:navigate
                class="nav-link {{ request()->routeIs('reviewer.review.pengabdian.proposal.index') ? 'active' : '' }}">
                Proposal
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('reviewer.review.pengabdian.laporan.index') }}" wire:navigate
                class="nav-link {{ request()->routeIs('reviewer.review.pengabdian.laporan.index') ? 'active' : '' }}">
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
    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Judul Laporan</th>
                        <th>Ketua Pengusul</th>
                        <th>Status Review</th>
                        <th class="text-center" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporans as $index => $laporan)
                        @php
                            $proposal = $laporan->proposalPengabdian;
                            [$class, $label] = match ($laporan->status) {
                                'pending' => ['text-bg-warning', 'Menunggu Review'],
                                'approved_by_reviewer' => ['text-bg-success', 'Disetujui'],
                                'revisi' => ['text-bg-warning', 'Perlu Revisi'],
                                'rejected' => ['text-bg-danger', 'Ditolak'],
                                'final' => ['text-bg-primary', 'Final'],
                                default => ['text-bg-secondary', ucfirst($laporan->status ?? '-')],
                            };
                        @endphp
                        <tr wire:key="laporan-{{ $laporan->id }}">
                            <td>{{ $index + $laporans->firstItem() }}</td>
                            <td>{{ $laporan->judul ?? '-' }}</td>
                            <td>{{ $proposal->ketuaPengusul->name ?? '-' }}</td>
                            <td><span class="badge {{ $class }}">{{ $label }}</span></td>
                            <td class="text-center">
                                <a wire:navigate
                                    href="{{ route('reviewer.review.pengabdian.laporan.form', ['laporanId' => $laporan->id]) }}"
                                    class="btn btn-outline-primary btn-sm rounded-3 d-inline-flex align-items-center gap-1 px-2">
                                    <i class="bi bi-eye"></i>
                                    <span>review</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Tidak ada laporan yang ditugaskan.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- 🔹 Pagination --}}
        @if ($laporans->hasPages())
            <div class="card-footer bg-transparent">
                {{ $laporans->links(data: ['wire:navigate' => true]) }}
            </div>
        @endif
    </div>
</div>
</div>

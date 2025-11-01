@props([
    'entries',
    'columns',
    'routeResolver' => null, 
])

<div class="mb-4 shadow-none">
    <div class="">
        <table class="table table-hover table-sm shadow-none align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 10px">No</th>
                    @foreach ($columns as $col)
                        <th>{{ $col['label'] }}</th>
                    @endforeach
                    <th class="text-center" style="width: 120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($entries as $index => $entry)
                    <tr>
                        <td>{{ $index + ($entries->firstItem() ?? 0) }}.</td>

                        {{-- Kolom --}}
                        @foreach ($columns as $col)
                            @php
                                $keys = explode('.', $col['key']);
                                $value = $entry;
                                foreach ($keys as $key) {
                                    $value = $value[$key] ?? ($value->$key ?? null);
                                }
                                $type = $col['type'] ?? 'text';
                            @endphp

                            <td>
                                @switch($type)
                                    @case('status')
                                        @php
                                            [$statusClass, $statusLabel] = match ($value) {
                                                'menunggu_validasi_reviewer' => [
                                                    'text-bg-warning',
                                                    'Menunggu Reviewer',
                                                ],
                                                'menunggu_validasi_prpm' => ['text-bg-warning', 'Menunggu PRPM'],
                                                'approved_by_reviewer' => ['text-bg-success', 'Disetujui Reviewer'],
                                                'revisi' => ['text-bg-warning', 'Perlu Revisi'],
                                                'rejected' => ['text-bg-danger', 'Ditolak'],
                                                'final' => ['text-bg-primary', 'Final'],
                                                default => ['text-bg-secondary', ucfirst($value ?? 'Tidak Diketahui')],
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                    @break

                                    @default
                                        {{ Str::limit($value, 40, '...') ?? '-' }}
                                @endswitch
                            </td>
                        @endforeach
                        @php
                            // Jika ada prop routeResolver (misal "review.prpm"), maka route akan dihasilkan otomatis
                            $reviewRoute = isset($routeResolver)
                                ? route($routeResolver, $entry)
                                : $entry->review_route ?? '#';
                                
                        @endphp

             

                        {{-- Aksi berdasarkan context --}}
                        <td class="text-center">
                                <a href="{{ $reviewRoute }}" class="btn btn-light btn-sm rounded-pill px-3">
                                    <i class="bi bi-pencil-square text-primary"></i>
                                </a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 2 }}" class="text-center text-muted py-4">
                                Tidak ada data ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $entries->links() ?? '' }}
        </div>
    </div>

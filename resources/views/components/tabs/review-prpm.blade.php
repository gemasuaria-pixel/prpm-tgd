@props([
    'active' => '',
    'domain' => 'penelitian', // default kalau tidak diisi
])

@php
    // Mapping dinamis antar domain & route prefix
    $routes = [
        'penelitian' => [
            'proposal' => 'ketua-prpm.review.penelitian.proposal.index',
            'laporan'  => 'ketua-prpm.review.penelitian.laporan.index',
        ],
        'pengabdian' => [
            'proposal' => 'ketua-prpm.review.pengabdian.proposal.index',
            'laporan'  => 'ketua-prpm.review.pengabdian.laporan.index',
        ],
    ];

    // Pastikan domain valid
    $domainRoutes = $routes[$domain] ?? $routes['penelitian'];
@endphp

<ul class="nav nav-tabs mt-3 px-3" id="reviewTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route($domainRoutes['proposal']) }}"
           class="nav-link {{ $active === 'proposal' ? 'active' : '' }}">
            Proposal {{ ucfirst($domain) }}
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route($domainRoutes['laporan']) }}"
           class="nav-link {{ $active === 'laporan' ? 'active' : '' }}">
            Laporan {{ ucfirst($domain) }}
        </a>
    </li>
</ul>

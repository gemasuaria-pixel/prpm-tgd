@props([
    'tabs' => [],       // array label => url
    'active' => '',     // tab yang aktif, bisa optional
])

@if(!empty($tabs))
<ul class="nav nav-tabs mt-3 px-3" id="reviewTabs" role="tablist">
    @foreach($tabs as $label => $url)
        @php
            // Tentukan active tab:
            $isActive = $active
                ? $active === $label
                : request()->url() === $url; // fallback auto detect dari URL
        @endphp
        <li class="nav-item" role="presentation">
            <a href="{{ $url }}"
               class="nav-link {{ $isActive ? 'active' : '' }}">
                {{ $label }}
            </a>
        </li>
    @endforeach
</ul>
@endif

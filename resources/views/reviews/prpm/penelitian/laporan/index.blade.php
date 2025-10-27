@extends('layouts.main')

@section('content')
<main class="app-main">
    <x-breadcrumbs>Review PRPM</x-breadcrumbs>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    {{-- Komponen Tabs --}}
                  <x-tabs.review-prpm domain="penelitian" active="laporan" />
                    {{-- Komponen Table --}}
                    <x-table.review-prpm :entries="$laporans" />
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@extends('layouts.main')

@section('content')
<main class="app-main">
    <x-breadcrumbs>Review</x-breadcrumbs>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    {{-- Komponen Tabs --}}
                    <x-tabs.review-prpm domain="penelititan" active="proposal" />

                    {{-- Komponen Table --}}
                    <x-table.review-prpm :entries="$entries" />
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@extends('layouts.main')

@section('content')
    <main class="app-main">
        <x-breadcrumbs>Review PRPM</x-breadcrumbs>

        <div class="app-content">
            <div class="container-fluid">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-0">

                        <livewire:reviews.prpm.pengabdian.laporan.reviews-form :laporan-id="$laporanId"/>
                       

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@extends('layouts.main')

@section('content')
<main class="app-main">
    <div class="app-content">
        <div class="container">
            <x-breadcrumbs>Proposal Pengabdian</x-breadcrumbs>

            {{-- Komponen utama Livewire yang mengatur semua langkah --}}
            <livewire:pengabdian.proposal.proposal-wizard />
        </div>
    </div>
</main>
@endsection

@extends('layouts.main')

@section('content')
<main class="app-main">
    <div class="app-content">
        <div class="container">
            <x-breadcrumbs>Laporan pengabdian</x-breadcrumbs>

            {{-- Livewire Component --}}
           <livewire:pengabdian.laporan.laporan-wizard :proposal-id="$proposalId"/>
        </div>
    </div>
</main>
@endsection


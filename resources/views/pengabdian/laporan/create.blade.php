@extends('layouts.main')

@section('content')
<main class="app-main">
    <div class="app-content">
        <div class="container">
            <x-breadcrumbs>Proposal Penelitian</x-breadcrumbs>

            {{-- Livewire Component --}}
           <livewire:pengabdian.laporan.laporan-wizard :proposal-id="$proposalId"/>
        </div>
    </div>
</main>
@endsection


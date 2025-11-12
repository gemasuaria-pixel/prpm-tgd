@extends('layouts.main')

@section('content')
<main class="app-main">
    <div class="app-content">
        <div class="container">
            <x-breadcrumbs>Proposal Penelitian</x-breadcrumbs>

            {{-- Livewire Component --}}
           <livewire:penelitian.proposal.proposal-wizard />
        </div>
    </div>
</main>
@endsection


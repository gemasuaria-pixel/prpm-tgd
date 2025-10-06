@extends('layouts.main')

@section('content')
    <main class="app-main">
        <x-breadcrumbs>Dashboard / Assign Role</x-breadcrumbs>
        <div class="app-content">
            <div class="container-fluid py-4">
                    <livewire:admin.assign-role />

            </div>
        </div>
    </main>
@endsection

@extends('layouts.main')

@section('content')
    <main class="app-main">
        <x-breadcrumbs>Review PRPM</x-breadcrumbs>

        <div class="app-content">
            <div class="container-fluid">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-0">
                        {{-- Komponen Tabs --}}
                        <x-tabs.review-prpm :tabs="[
                            'proposal' => route('reviewer.review.pengabdian.proposal.index'),
                            'laporan' => route('reviewer.review.pengabdian.laporan.index'),
                        ]" active="laporan"  />

                        {{-- Komponen Table --}}
                        <x-table.review-prpm :entries="$laporans" routeResolver="reviewer.review.pengabdian.laporan.form"
                            :columns="[
                                ['label' => 'Judul', 'key' => 'reviewable.judul'],
                                ['label' => 'Ketua Pengusul', 'key' => 'reviewable.proposalPengabdian.ketuaPengusul.name'],
                                ['label' => 'Rumpun Ilmu', 'key' => 'reviewable.proposalPengabdian.rumpun_ilmu'],
                                ['label' => 'Status', 'key' => 'status', 'type' => 'status'],
                            ]" />

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

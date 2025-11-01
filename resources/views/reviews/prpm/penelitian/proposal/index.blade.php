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
                            'proposal' => route('ketua-prpm.review.penelitian.proposal.index'),
                            'laporan' => route('ketua-prpm.review.penelitian.laporan.index'),
                        ]" active="proposal"  />

                        {{-- Komponen Table --}}
                        <x-table.review-prpm :entries="$proposals" routeResolver="ketua-prpm.review.penelitian.proposal.form"
                            :columns="[
                                ['label' => 'Judul', 'key' => 'judul'],
                                ['label' => 'Ketua Pengusul', 'key' => 'ketuaPengusul.name'],
                                ['label' => 'Rumpun Ilmu', 'key' => 'rumpun_ilmu'],
                                ['label' => 'Status', 'key' => 'status', 'type' => 'status'],
                            ]" />

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

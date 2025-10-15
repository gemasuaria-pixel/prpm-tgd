@extends('layouts.main')

@section('content')
    <main class="app-main">
        <x-breadcrumbs>Review PRPM</x-breadcrumbs>

        <div class="app-content">
            <div class="container-fluid">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-0">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs mt-3 px-3" id="reviewTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="proposal-tab" data-bs-toggle="tab"
                                    data-bs-target="#proposal" type="button" role="tab">
                                    Proposal Penelitian
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="laporan-tab" data-bs-toggle="tab" data-bs-target="#laporan"
                                    type="button" role="tab">
                                    Laporan Penelitian
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content mt-4 p-3" id="reviewTabsContent">
                            {{-- ================== TAB PROPOSAL ================== --}}
                            {{-- ================== TAB PROPOSAL ================== --}}
                            <div class="tab-pane fade show active" id="proposal" role="tabpanel">
                                @include('reviews.prpm._proposal-table')
                            </div>


                            {{-- ================== TAB LAPORAN ================== --}}
                            <div class="tab-pane fade" id="laporan" role="tabpanel">
                                @include('reviews.prpm._laporan-table')
                            </div>
                        </div> {{-- end tab-content --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

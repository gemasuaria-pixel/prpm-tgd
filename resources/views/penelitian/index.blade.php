@extends('layouts.main')
@section('content')
    <!--begin::App Main-->
    <main class="app-main">
        <x-breadcrumbs>Status Penelitian</x-breadcrumbs>
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->

            <body>

                <div class="container-fluid py-4">
                    <!--begin::Row-->


                    <div class="row g-3">
                        <!-- ======================== -->
                        <!-- PROPOSAL -->
                        <!-- ======================== -->
                        <div class="col-4 col-lg-2">
                            <div class="card shadow-sm h-100 position-relative">
                                <div class="accent-bar bg-success"></div>
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <small class="text-secondary text-uppercase fw-semibold mb-1">Proposal</small>
                                    <div class="icon-square bg-success-subtle text-success mb-2 rounded-circle">
                                        <i class="bi bi-check-circle-fill fs-4"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-success mb-0">{{ $proposalDiterimaCount ?? 0 }}</h5>
                                    <p class="card-text text-success text-center">Diterima</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 col-lg-2">
                            <div class="card shadow-sm h-100 position-relative">
                                <div class="accent-bar bg-warning"></div>
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <small class="text-secondary text-uppercase fw-semibold mb-1">Proposal</small>
                                    <div class="icon-square bg-warning-subtle text-warning mb-2 rounded-circle">
                                        <i class="bi bi-hourglass-split fs-4"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-warning mb-0">{{ $proposalDiprosesCount ?? 0 }}</h5>
                                    <p class="card-text text-warning text-center">Diproses</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 col-lg-2">
                            <div class="card shadow-sm h-100 position-relative">
                                <div class="accent-bar bg-danger"></div>
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <small class="text-secondary text-uppercase fw-semibold mb-1">Proposal</small>
                                    <div class="icon-square bg-danger-subtle text-danger mb-2 rounded-circle">
                                        <i class="bi bi-x-circle-fill fs-4"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-danger mb-0">{{ $proposalDitolakCount ?? 0 }}</h5>
                                    <p class="card-text text-danger text-center">Ditolak</p>
                                </div>
                            </div>
                        </div>

                        <!-- ======================== -->
                        <!-- LAPORAN -->
                        <!-- ======================== -->
                        <div class="col-4 col-lg-2">
                            <div class="card shadow-sm h-100 position-relative">
                                <div class="accent-bar bg-primary"></div>
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <small class="text-secondary text-uppercase fw-semibold mb-1">Laporan</small>
                                    <div class="icon-square bg-primary-subtle text-primary mb-2 rounded-3">
                                        <i class="bi bi-check-circle-fill fs-4"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-primary mb-0">{{ $laporanDiterimaCount ?? 0 }}</h5>
                                    <p class="card-text text-primary text-center">Diterima</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 col-lg-2">
                            <div class="card shadow-sm h-100 position-relative">
                                <div class="accent-bar bg-warning"></div>
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <small class="text-secondary text-uppercase fw-semibold mb-1">Laporan</small>
                                    <div class="icon-square bg-warning-subtle text-warning mb-2 rounded-3">
                                        <i class="bi bi-hourglass-split fs-4"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-warning mb-0">{{ $laporanDiprosesCount ?? 0 }}</h5>
                                    <p class="card-text text-warning text-center">Diproses</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 col-lg-2">
                            <div class="card shadow-sm h-100 position-relative">
                                <div class="accent-bar bg-danger"></div>
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <small class="text-secondary text-uppercase fw-semibold mb-1">Laporan</small>
                                    <div class="icon-square bg-danger-subtle text-danger mb-2 rounded-3">
                                        <i class="bi bi-x-circle-fill fs-4"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-danger mb-0">{{ $laporanDitolakCount ?? 0 }}</h5>
                                    <p class="card-text text-danger text-center">Ditolak</p>
                                </div>
                            </div>
                        </div>
                    </div>




                    <!--end::Row-->
                    <div class="row my-2">
                        <div class="col-md-6 d-grid ">
                            @if ($isProfileComplete)
                                <a href="{{ route('dosen.ProposalPenelitian') }}"
                                    class="btn btn-outline-primary btn-lg rounded-3 fw-semibold shadow-sm">
                                    <i class="bi bi-plus-circle me-2"></i> Usulan Penelitian
                                </a>
                            @else
                                <button class="btn btn-outline-secondary btn-lg rounded-3 fw-semibold shadow-sm" disabled
                                    title="Lengkapi profil Anda terlebih dahulu">
                                    <i class="bi bi-plus-circle me-2"></i> Usulan Penelitian
                                </button>
                            @endif
                        </div>

                        <div class="col-md-6 d-grid">
                            <a href="{{ $proposalFinal ? route('dosen.uploadLaporan') : '#' }}"
                                class="btn btn-lg rounded-3 fw-semibold shadow-sm 
            {{ $proposalFinal ? 'btn-outline-success' : 'btn-secondary disabled' }}"
                                id="laporanBtn">
                                <i class="bi bi-file-earmark-text me-2"></i> Laporan Penelitian
                            </a>
                        </div>

                    </div>


                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Status Penelitian</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive-md">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Upload</th>
                                            <th>Judul</th>
                                            <th>Jenis</th>
                                            <th>Status</th>
                                            <th>Tanggal Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Contoh row kosong / skeleton --}}
                                        <tr class="align-middle">
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>
                                                <span class="badge text-bg-secondary">--</span>
                                            </td>
                                            <td>--</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-end">
                                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div>
                    </div>

                </div>




                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>





        </div>
        <!--end::Container-->
        </div>


        <!--end::App Content-->
    </main>
@endsection

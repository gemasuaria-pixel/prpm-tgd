@extends('layouts.main')
@section('content')
    <!--begin::App Main-->
    <main class="app-main">
        <x-breadcrumbs>Dashoard </x-breadcrumbs>
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <!--end::Col-->
                    <div class=" col">
                        <!--begin::Small Box Widget 2-->
                        <div class="small-box text-black  bg-success-subtle">
                            <div class="inner">
                                <h3 class="text-success">53</h3>
                                <p class="text-success">Dokumen<br>Diterima</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="small-box-icon" fill="#198754"
                                viewBox="0 0 640 640">
                                <path
                                    d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM404.4 276.7L324.4 404.7C320.2 411.4 313 415.6 305.1 416C297.2 416.4 289.6 412.8 284.9 406.4L236.9 342.4C228.9 331.8 231.1 316.8 241.7 308.8C252.3 300.8 267.3 303 275.3 313.6L302.3 349.6L363.7 251.3C370.7 240.1 385.5 236.6 396.8 243.7C408.1 250.8 411.5 265.5 404.4 276.8z" />
                            </svg>

                        </div>
                        <!--end::Small Box Widget 2-->
                    </div>
                    <!--end::Col-->
                    <div class="col">
                        <!--begin::Small Box Widget 3-->
                        <div class="small-box bg-warning-subtle">
                            <div class="inner">
                                <h3 class="alert-link">44</h3>
                                <p>Dokumen <br>Diproses</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ffc107"
                                class="small-box-icon">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z"
                                    clip-rule="evenodd" />
                            </svg>


                        </div>
                        <!--end::Small Box Widget 3-->
                    </div>
                    <!--end::Col-->
                    <div class="col">
                        <!--begin::Small Box Widget 4-->
                        <div class="small-box bg-danger-subtle">
                            <div class="inner text-danger">
                                <h3>65</h3>
                                <p>Dokumen <br> Ditolak</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#dc3545"
                                class="small-box-icon">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                                    clip-rule="evenodd" />
                            </svg>


                        </div>
                        <!--end::Small Box Widget 4-->
                    </div>
                    <!--end::Col-->
                    <div class="col">
                        <!--begin::Small Box Widget 4-->
                        <div class="small-box bg-primary-subtle">
                            <div class="inner text-primary">
                                <h3>65</h3>
                                <p>Luaran <br> Dapat Diklaim</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#0D6EFD"
                                class="small-box-icon">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                                    clip-rule="evenodd" />
                            </svg>


                        </div>
                        <!--end::Small Box Widget 4-->
                    </div>
                </div>
                <!--end::Row-->


                <!--begin::Row-->



                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Status penelitian</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive-md">
                            <table class="table table-bordered ">
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
                                    <tr class="align-middle">
                                        <td>23 - 01 - 2025</td>
                                        <td>Update software</td>
                                        <td>
                                            Laporan
                                        </td>
                                        <td><span class="badge text-bg-danger">Ditolak</span></td>
                                        <td>23 - 01 - 2025</td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>23 - 01 - 2025</td>
                                        <td>Clean database</td>
                                        <td>
                                            Laporan
                                        </td>
                                        <td><span class="badge text-bg-warning">Menunggu</span></td>
                                        <td>23 - 01 - 2025</td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>23 - 01 - 2025</td>
                                        <td>Cron job running</td>
                                        <td>
                                            Laporan
                                        </td>
                                        <td><span class="badge text-bg-success">Disetujui</span></td>
                                        <td>23 - 01 - 2025</td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>23 - 01 - 2025</td>
                                        <td>Fix and squish bugs</td>
                                        <td>
                                            Laporan
                                        </td>
                                        <td><span class="badge text-bg-success">Disetujui</span></td>
                                        <td>23 - 01 - 2025</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- /.card-body -->
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
                <!-- /.card -->
                <!-- /.row (main row) -->



                <x-chart>
                </x-chart>



                <div class="card border shadow-sm mb-4">


                    <!-- Header -->
                    <div class="card-header bg-light d-flex align-items-center">
                        <div class="rounded-circle bg-primary d-flex justify-content-center align-items-center me-4"
                            style="width: 48px; height: 48px;">
                            <i class="bi bi-person text-white fs-5"></i>
                            <!-- pakai Bootstrap Icons -->
                        </div>
                        <div>
                            <h3 class="h6 fw-semibold  mb-1">ZAIMAH PANJAITAN</h3>
                            <p class="small text-muted mb-0">Program Studi Sistem Informasi</p>
                        </div>


                    </div>

                    <!-- Details -->
                    <div class="card-body">
                        <div class="row gy-3 gx-5">
                            <div class="col-md-6">
                                <p class="small text-muted mb-1">NIDN/NIDK</p>
                                <p class="fw-medium text-dark mb-0">0120098903</p>
                            </div>
                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Tempat Tanggal Lahir</p>
                                <p class="fw-medium text-dark mb-0">-</p>
                            </div>

                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Klaster</p>
                                <p class="fw-medium text-dark mb-0">Kelompok PT Binaan</p>
                            </div>
                            <div class="col-md-6">
                                <p class="small text-muted mb-1">No KTP</p>
                                <p class="fw-medium text-dark mb-0">-</p>
                            </div>

                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Institusi</p>
                                <p class="fw-medium text-dark mb-0">STMIK Triguna Dharma</p>
                            </div>
                            <div class="col-md-6">
                                <p class="small text-muted mb-1">No Telepon</p>
                                <p class="fw-medium text-dark mb-0">-</p>
                            </div>

                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Program Studi</p>
                                <p class="fw-medium text-dark mb-0">Sistem Informasi</p>
                            </div>
                            <div class="col-md-6">
                                <p class="small text-muted mb-1">No HP</p>
                                <p class="fw-medium text-dark mb-0">-</p>
                            </div>

                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Jenjang Pendidikan</p>
                                <p class="fw-medium text-dark mb-0">S2</p>
                            </div>
                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Alamat Surel</p>
                                <p class="fw-medium text-dark mb-0">-</p>
                            </div>

                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Jabatan Akademik</p>
                                <p class="fw-medium text-dark mb-0">Asisten Ahli</p>
                            </div>
                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Website Personal</p>
                                <p class="fw-medium text-dark mb-0">-</p>
                            </div>

                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Alamat</p>
                                <p class="fw-medium text-dark mb-0">-</p>
                            </div>
                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mb-4 me-4">
                        <button type="button" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-repeat me-2"></i>
                            Sync PDDIKTI
                        </button>
                        <button type="button" class="btn btn-primary">
                            <i class="bi bi-pencil-square me-2"></i>
                            Sunting
                        </button>
                    </div>

                </div>


                <div class="mb-5">
                    <h2 class="h5 fw-semibold text-dark mb-4">PROFIL ANDA</h2>

                    <div class="row g-4">
                        <!-- Identitas -->
                        <div class="col-12 col-md-4">
                            <div class="card border shadow-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="small text-muted mb-1">Identitas</p>
                                            <p class="fw-semibold text-dark mb-0">ZAIMAH PANJAITAN</p>
                                        </div>
                                        <div class="col-auto text-end">
                                            <div class="rounded-circle bg-primary d-flex justify-content-center align-items-center"
                                                style="width:40px; height:40px;">
                                                <i class="bi bi-person text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Penelitian -->
                        <div class="col-12 col-md-4">
                            <div class="card border shadow-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="small text-muted mb-1">Penelitian</p>
                                            <p class="h4 fw-bold text-dark mb-0">2</p>
                                        </div>
                                        <div class="col-auto text-end">
                                            <div class="rounded-circle bg-primary d-flex justify-content-center align-items-center"
                                                style="width:40px; height:40px;">
                                                <i class="bi bi-search text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengabdian -->
                        <div class="col-12 col-md-4">
                            <div class="card border shadow-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="small text-muted mb-1">Pengabdian</p>
                                            <p class="h4 fw-bold text-dark mb-0">1</p>
                                        </div>
                                        <div class="col-auto text-end">
                                            <div class="rounded-circle bg-primary d-flex justify-content-center align-items-center"
                                                style="width:40px; height:40px;">
                                                <i class="bi bi-star text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Artikel -->
                        <div class="col-12 col-md-4 m-0">
                            <<div class="card border shadow-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">

                                        <!-- Kiri -->
                                        <div class="col">
                                            <p class="small text-muted mb-1">Artikel Jurnal</p>
                                            <p class="h4 fw-bold text-dark mb-0">0</p>
                                        </div>

                                        <!-- Kanan -->
                                        <div class="col-auto text-end">
                                            <div class="rounded-circle bg-primary d-flex justify-content-center align-items-center"
                                                style="width:40px; height:40px;">
                                                <i class="bi bi-file-text text-white"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                        </div>


                    </div>

                    <!-- Sinta Skor Overall -->
                    <div class="col-12 col-md-4">
                        <div class="card border shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <!-- Teks -->
                                    <div class="col">
                                        <p class="small text-muted mb-1">Sinta Skor Overall</p>
                                        <p class="h4 fw-bold text-dark mb-0">239</p>
                                    </div>
                                    <!-- Ikon -->
                                    <div class="col-auto text-end">
                                        <div class="rounded-circle bg-primary d-flex justify-content-center align-items-center"
                                            style="width:40px; height:40px;">
                                            <i class="bi bi-graph-up text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>



        </div>
        <!--end::Container-->
        </div>



        <!--end::App Content-->
    </main>
@endsection

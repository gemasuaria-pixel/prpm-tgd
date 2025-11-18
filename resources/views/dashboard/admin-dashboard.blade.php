@extends('layouts.main')
@section('content')
    <!--begin::App Main-->
    <main class="app-main">
        <x-breadcrumbs>Dashoard </x-breadcrumbs>
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">

                 <div class="container my-4">
                        <div class="card border-0 text-white" style="background-color: #0d6efd; border-radius: 20px;">

                            <div class="card-body p-5 d-flex flex-column flex-md-row align-items-center">

                                <!-- Left Section -->
                                <div class="col-md-6 mb-4 mb-md-0">
                                    <h1 class="fw-bold display-5">
                                        Halo Admin <span>👋</span>
                                    </h1>
                                    <p class="mt-2 fs-5">
                                        cek aktivitas terkini para user yuk!
                                    </p>
                                    <a href="#" class="btn btn-light btn-lg mt-3"
                                        style="border-radius: 10px; padding: 10px 25px;">
                                        cek aktivitas
                                    </a>
                                </div>

                                <!-- Right Section (Image) -->
                                <div class="col-md-6 d-flex justify-content-center">
                                    <img src="{{ asset('banner.png') }}" alt="banner" class="img-fluid"
                                        style="max-height: 220px;">
                                </div>

                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Dosen Paling Aktif</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table">

                                    <tbody>
                                        <tr class="align-middle">
                                            <td>
                                                <img src="https://picsum.photos/200" alt="avatar"
                                                    class="rounded-circle me-2" width="40" height="40">
                                                Liliana Ayas
                                            </td>
                                            <td>
                                                <span class="badge text-bg-success">4.5</span>
                                            </td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td>
                                                <img src="https://picsum.photos/200" alt="avatar"
                                                    class="rounded-circle me-2" width="40" height="40">
                                                Grace Wijaya
                                            </td>
                                            <td>
                                                <span class="badge text-bg-success">4.5</span>
                                            </td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td>
                                                <img src="https://picsum.photos/200" alt="avatar"
                                                    class="rounded-circle me-2" width="40" height="40">
                                                Citra Andini
                                            </td>
                                            <td>
                                                <span class="badge text-bg-success">4.5</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.col -->

                    {{-- target tahunan  --}}
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body text-center p-4">
                                <div class="icon-wrapper bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                    style="width:60px; height:60px;">
                                    <i class="bi bi-bullseye fs-3 text-primary"></i>
                                </div>
                                <h1 class="fw-bold text-dark">83</h1>
                                <p class="text-muted mb-0">Target Tahunan</p>
                            </div>
                        </div>
                    </div>

                    {{-- progress dokumen terbaru --}}
                    <div class="col-md-7">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Progress Dokumen Terbaru</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Dosen</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Hari/ Tanggal</th>
                                            <th style="width: 40px">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="align-middle">
                                            <td>1.</td>
                                            <td>Update software</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge text-bg-danger">55%</span></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td>2.</td>
                                            <td>Clean database</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar text-bg-warning" style="width: 70%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge text-bg-warning">70%</span></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td>3.</td>
                                            <td>Cron job running</td>
                                            <td>
                                                <div class="progress progress-xs progress-striped active">
                                                    <div class="progress-bar text-bg-primary" style="width: 30%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge text-bg-primary">30%</span></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td>4.</td>
                                            <td>Fix and squish bugs</td>
                                            <td>
                                                <div class="progress progress-xs progress-striped active">
                                                    <div class="progress-bar text-bg-success" style="width: 90%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge text-bg-success">90%</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>

                    <div class="col-md-5">
                        <!-- PRODUCT LIST -->
                        <div class="card pt-3">
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="px-2">
                                    <div class="d-flex border-top py-2 px-1">
                                        <div class="col-2">
                                            <img src="https://picsum.photos/200" alt="Product Image" class="img-size-50" />
                                        </div>
                                        <div class="col-10">
                                            <a href="javascript:void(0)" class="fw-bold">
                                                Ahmad Temola

                                            </a>
                                            <div class="text-truncate">Samsung 32" 1080p 60Hz LED Smart HDTV.</div>
                                        </div>
                                    </div>
                                    <!-- /.item -->
                                    <div class="d-flex border-top py-2 px-1">
                                        <div class="col-2">
                                            <img src="https://picsum.photos/200" alt="Product Image" class="img-size-50" />
                                        </div>
                                        <div class="col-10">
                                            <a href="javascript:void(0)" class="fw-bold">
                                                Ahmad Temola

                                            </a>
                                            <div class="text-truncate">
                                                26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.item -->
                                    <div class="d-flex border-top py-2 px-1">
                                        <div class="col-2">
                                            <img src="https://picsum.photos/200" alt="Product Image"
                                                class="img-size-50" />
                                        </div>
                                        <div class="col-10">
                                            <a href="javascript:void(0)" class="fw-bold">
                                                Ahmad Temola

                                            </a>
                                            <div class="text-truncate">
                                                Xbox One Console Bundle with Halo Master Chief Collection.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.item -->
                                    <div class="d-flex border-top py-2 px-1">
                                        <div class="col-2">
                                            <img src="https://picsum.photos/200" alt="Product Image"
                                                class="img-size-50" />
                                        </div>
                                        <div class="col-10">
                                            <a href="javascript:void(0)" class="fw-bold">
                                                Ahmad Temola
                                            </a>
                                            <div class="text-truncate">PlayStation 4 500GB Console (PS4)</div>
                                        </div>
                                    </div>
                                    <!-- /.item -->
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="javascript:void(0)" class="uppercase"> Lihat seluruh notifikasi </a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>


                </div>
            </div><!-- /.container-fluid -->

    </main>
@endsection

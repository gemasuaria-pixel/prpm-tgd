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

                    <div class="col">
                        <!--begin::Small Box Widget 4-->
                        <div class="small-box bg-primary-subtle">
                            <div class="inner text-primary">
                                <h3>6</h3>
                                <p>usulan <br> dikirim</p>
                            </div>
                            <i class="bi bi-send-fill small-box-icon text-primary" style="font-size: 60px;"></i>

                        </div>
                        <!--end::Small Box Widget 4-->
                    </div>
                    <!--end::Col-->
                    <div class=" col">
                        <!--begin::Small Box Widget 2-->
                        <div class="small-box text-black  bg-success-subtle">
                            <div class="inner">
                                <h3 class="text-success">2</h3>
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
                                <h3 class="alert-link">2</h3>
                                <p>Dokumen <br>DItinjau</p>
                            </div>
                            <i class="bi bi-hourglass-split small-box-icon text-warning"style="font-size: 60px;"></i>

                        </div>
                        <!--end::Small Box Widget 3-->
                    </div>
                    <!--end::Col-->
                    <div class="col">
                        <!--begin::Small Box Widget 4-->
                        <div class="small-box bg-danger-subtle">
                            <div class="inner text-danger">
                                <h3>2</h3>
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
    <!-- PENELITIAN -->
    <tr class="align-middle">
        <td>07 - 02 - 2025</td>
        <td>Optimasi Sistem Penjadwalan Akademik</td>
        <td>Penelitian - Proposal</td>
        <td><span class="badge text-bg-warning">Menunggu Review</span></td>
        <td>—</td>
    </tr>

    <tr class="align-middle">
        <td>02 - 02 - 2025</td>
        <td>Analisis Keamanan Jaringan pada Server Kampus</td>
        <td>Penelitian - Proposal</td>
        <td><span class="badge text-bg-danger">Ditolak</span></td>
        <td>04 - 02 - 2025</td>
    </tr>

    <!-- PENGABDIAN -->
    <tr class="align-middle">
        <td>28 - 01 - 2025</td>
        <td>Pelatihan Literasi Digital untuk Masyarakat Desa</td>
        <td>Pengabdian - Proposal</td>
        <td><span class="badge text-bg-success">Disetujui</span></td>
        <td>29 - 01 - 2025</td>
    </tr>

    <tr class="align-middle">
        <td>26 - 01 - 2025</td>
        <td>Workshop Keamanan Data untuk UMKM</td>
        <td>Pengabdian - Laporan Kemajuan</td>
        <td><span class="badge text-bg-warning">Menunggu Review</span></td>
        <td>—</td>
    </tr>

    <tr class="align-middle">
        <td>24 - 01 - 2025</td>
        <td>Pendampingan Digitalisasi Administrasi Sekolah</td>
        <td>Pengabdian - Proposal</td>
        <td><span class="badge text-bg-danger">Ditolak</span></td>
        <td>25 - 01 - 2025</td>
    </tr>

    <tr class="align-middle">
        <td>22 - 01 - 2025</td>
        <td>Sosialisasi Manajemen Waktu untuk Remaja</td>
        <td>Pengabdian - Laporan Akhir</td>
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


            </div>
            <!--end::Container-->
        </div>



        <!--end::App Content-->
    </main>
@endsection

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
                    <div class="row">
                        <!--end::Col-->
                        <div class=" col">
                            <!--begin::Small Box Widget 2-->
                            <div class="small-box text-black  bg-success-subtle">
                                <div class="inner">
                                    <h3 class="text-success">53</h3>
                                    <p class="text-success">Penelitian<br>Diterima</p>
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
                                    <p>Penelitian <br>Diproses</p>
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
                                    <p>Penelitian <br> Ditolak</p>
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

                    <!-- Tombol Usulan & Laporan -->
                    <div class="row my-4">
                        <div class="col-md-6 d-grid mb-3 mb-md-0">
                            <a href="{{ route('dosen.ProposalPenelitian') }}"
                                class="btn btn-outline-primary btn-lg rounded-3 fw-semibold shadow-sm">
                                <i class="bi bi-plus-circle me-2"></i> Usulan Penelitian
                            </a>
                        </div>

                        @if ($proposalFinal)
                            <div class="col-md-6 d-grid">
                                <a href="{{ route('dosen.uploadLaporan') }}"
                                    class="btn btn-outline-success btn-lg rounded-3 fw-semibold shadow-sm">
                                    <i class="bi bi-file-earmark-text me-2"></i> Laporan Penelitian
                                </a>
                            </div>
                        @endif
                    </div>


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
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            </body>

            </html>




        </div>
        <!--end::Container-->
        </div>


        <!--end::App Content-->
    </main>
@endsection

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
                    <!-- Dokumen Diterima -->
                    <div class="col">
                        <div class="small-box text-black bg-success-subtle">
                            <div class="inner">
                                <h3 class="text-success">{{ $diterimaCount }}</h3>
                                <p class="text-success">Dokumen<br>Diterima</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="small-box-icon" fill="#198754"
                                viewBox="0 0 640 640">
                                <path
                                    d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM404.4 276.7L324.4 404.7C320.2 411.4 313 415.6 305.1 416C297.2 416.4 289.6 412.8 284.9 406.4L236.9 342.4C228.9 331.8 231.1 316.8 241.7 308.8C252.3 300.8 267.3 303 275.3 313.6L302.3 349.6L363.7 251.3C370.7 240.1 385.5 236.6 396.8 243.7C408.1 250.8 411.5 265.5 404.4 276.8z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Dokumen Diproses -->
                    <div class="col">
                        <div class="small-box bg-warning-subtle">
                            <div class="inner">
                                <h3 class="alert-link">{{ $diprosesCount }}</h3>
                                <p>Dokumen <br>Diproses</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ffc107"
                                class="small-box-icon">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- Dokumen Ditolak -->
                    <div class="col">
                        <div class="small-box bg-danger-subtle">
                            <div class="inner text-danger">
                                <h3>{{ $ditolakCount }}</h3>
                                <p>Dokumen <br> Ditolak</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#dc3545"
                                class="small-box-icon">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <!-- Luaran Dapat Diklaim -->
                    <div class="col">
                        <div class="small-box bg-primary-subtle">
                            <div class="inner text-primary">
                                <h3>{{ $luaranCount }}</h3>
                                <p>Luaran <br> Dapat Diklaim</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#0D6EFD"
                                class="small-box-icon">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!--end::Row-->


                <!--begin::Row-->





                <!-- /.card -->
                <!-- /.row (main row) -->






                <div class="card border shadow-sm mb-4">

                    <!-- Header -->
                    <div class="card-header bg-light d-flex align-items-center">
                        <div class="rounded-circle bg-primary d-flex justify-content-center align-items-center me-4"
                            style="width: 48px; height: 48px;">
                            <i class="bi bi-person text-white fs-5"></i>
                        </div>
                        <div>
                            <h3 class="h6 fw-semibold mb-1">{{ $user->full_name ?? $user->name }}</h3>
                            <p class="small text-muted mb-0">{{ $user->program_studi ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="card-body">
                        <div class="row gy-3 gx-5">
                            <div class="col-md-6">
                                <p class="small text-muted mb-1">NIDN</p>
                                <p class="fw-medium text-dark mb-0">{{ $user->nidn ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Tempat, Tanggal Lahir</p>
                                <p class="fw-medium text-dark mb-0">{{ $user->tempat_lahir ?? '-' }},
                                    {{ $user->tanggal_lahir ?? '-' }}</p>
                            </div>

                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Institusi</p>
                                <p class="fw-medium text-dark mb-0">{{ $user->institusi ?? '-' }}</p>
                            </div>


                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Kontak</p>
                                <p class="fw-medium text-dark mb-0">{{ $user->kontak ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="small text-muted mb-1">Alamat</p>
                                <p class="fw-medium text-dark mb-0">{{ $user->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mb-4 me-4">

                        <button type="button" class="btn btn-primary">
                            <i class="bi bi-pencil-square me-2"></i>
                            Sunting
                        </button>
                    </div>

                </div>




            </div>



        </div>
        <!--end::Container-->
        </div>



        <!--end::App Content-->
    </main>
@endsection

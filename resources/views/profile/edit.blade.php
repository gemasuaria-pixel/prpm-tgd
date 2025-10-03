@extends('layouts.main')
@section('content')
    <main class="app-main">
        <x-breadcrumbs>Pengaturan Pofil</x-breadcrumbs>
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid py-5">
                <!--begin::Row-->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">

                        <!-- Profile Photo Card -->
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-body text-center p-4">
                                <h5 class="fw-bold mb-1">Profile Photo</h5>
                                <p class="text-muted mb-4 small">Tambahkan atau perbarui foto profil Anda</p>

                                <form method="POST" action="{{ route('profile.photo.update') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex flex-column align-items-center">
                                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile Photo"
                                            class="rounded-circle shadow-sm mb-3"
                                            style="width: 100px; height: 100px; object-fit: cover;">

                                        <input type="file" name="photo" accept="image/*" class="form-control mb-3 w-50"
                                            required>

                                        <button type="submit" class="btn btn-primary px-4">
                                            Update Photo
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Update Profile Info -->
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-body p-4">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>

                        <!-- Update Password -->
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-body p-4">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>

                        <!-- Delete User -->
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body p-4">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

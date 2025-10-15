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

                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-body text-center p-4">
                                @include('profile.partials.profile-photo')
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

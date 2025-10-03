<x-guest-layout>
    <div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
        <div class="card shadow border-0 rounded-2" style="max-width: 450px; width:100%;">
            <div class="card-body p-4">

                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="{{ asset('logoPRPM.svg') }}" alt="Logo" class="mb-3 mx-auto" style="width: 70px;">
                    <h5 class="fw-bold mb-1">Sistem Informasi PRPM</h5>
                    <p class="text-muted small mb-0">Pusat Riset dan Pengabdian Masyarakat</p>
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold small text-uppercase">Nama Lengkap</label>
                        <input id="name" type="text"
                               class="form-control form-control-sm @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                        <x-input-error :messages="$errors->get('name')" class="invalid-feedback"/>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small text-uppercase">Email</label>
                        <input id="email" type="email"
                               class="form-control form-control-sm @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="invalid-feedback"/>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold small text-uppercase">Password</label>
                        <input id="password" type="password"
                               class="form-control form-control-sm @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password')" class="invalid-feedback"/>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold small text-uppercase">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password"
                               class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror"
                               name="password_confirmation" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="invalid-feedback"/>
                    </div>

                    <!-- Register Button -->
                    <div class="d-grid mb-2">
                        <button type="submit" class="btn btn-dark fw-semibold">
                            DAFTAR
                        </button>
                    </div>

                    <!-- Back to Login -->
                    <div class="text-center">
                        <small class="text-muted">Sudah punya akun?</small>
                        <a href="{{ route('login') }}" class="fw-semibold text-decoration-none ms-1">Masuk</a>
                    </div>
                </form>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <small class="text-muted">© 2025 Pusat Riset dan Pengabdian Masyarakat</small>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>

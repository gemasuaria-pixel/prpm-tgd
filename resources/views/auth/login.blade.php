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

                <!-- Session Status -->
                <x-auth-session-status class="mb-3" :status="session('status')" />

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small text-uppercase">Email</label>
                        <input id="email" type="email"
                               class="form-control form-control-sm @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="invalid-feedback"/>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold small text-uppercase">Password</label>
                        <input id="password" type="password"
                               class="form-control form-control-sm @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="invalid-feedback"/>
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="remember" id="remember_me" class="form-check-input">
                            <label for="remember_me" class="form-check-label small">Ingat saya</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-decoration-none text-primary">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <div class="d-grid mb-2">
                        <button type="submit" class="btn btn-dark fw-semibold">
                            MASUK
                        </button>
                    </div>

                    <!-- Register Button -->
                    @if (Route::has('register'))
                        <div class="d-grid">
                            <a href="{{ route('register') }}" class="btn btn-outline-primary fw-semibold">
                                DAFTAR AKUN BARU
                            </a>
                        </div>
                    @endif
                </form>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <small class="text-muted">© 2025 Pusat Riset dan Pengabdian Masyarakat</small>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>

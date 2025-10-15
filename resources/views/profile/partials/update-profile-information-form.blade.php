<section>
    <header>
        <h2 class="h5">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Form re-send verification -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Main Profile Form -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <!-- Username / Name -->
        <div>
            <x-input-label for="name" :value="__('Username')" />
            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Full Name -->
        <div class="mt-3">
            <x-input-label for="full_name" :value="__('Full Name')" />
            <x-text-input id="full_name" name="full_name" type="text" :value="old('full_name', $user->full_name)" required />
            <x-input-error :messages="$errors->get('full_name')" />
        </div>

        <!-- Email -->
        <div class="mt-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-muted mt-2 mb-0">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="btn btn-link text-secondary p-0">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success">
                            <strong>{{ __('A new verification link has been sent to your email address.') }}</strong>
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Additional Fields -->
        <div class="row g-3 mt-4">
            <div class="col-md-6">
                <x-input-label for="nidn" :value="__('NIDN / NIDK')" />
                <x-text-input id="nidn" name="nidn" type="text" :value="old('nidn', $user->nidn)" required />
                <x-input-error :messages="$errors->get('nidn')" />
            </div>

            <div class="col-md-6">
                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" :value="old('tempat_lahir', $user->tempat_lahir)" required />
                <x-input-error :messages="$errors->get('tempat_lahir')" />
            </div>

            <div class="col-md-6">
                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" :value="old('tanggal_lahir', $user->tanggal_lahir)" required />
                <x-input-error :messages="$errors->get('tanggal_lahir')" />
            </div>

            <div class="col-md-6">
                <x-input-label for="institusi" :value="__('Institusi')" />
                <x-text-input id="institusi" name="institusi" type="text" :value="old('institusi', $user->institusi)" required />
                <x-input-error :messages="$errors->get('institusi')" />
            </div>

            <div class="col-md-6">
    <x-input-label for="program_studi" :value="__('Program Studi')" />
    <select id="program_studi" name="program_studi" class="form-select" required>
        <option selected disabled>-- Pilih Program Studi --</option>
        <option value="Sistem Informasi" {{ old('program_studi', $user->program_studi) == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
        <option value="Teknik Informatika" {{ old('program_studi', $user->program_studi) == 'Sistem Komputer' ? 'selected' : '' }}>Sistem Komputer</option>
     
        <!-- Tambahkan program studi lain sesuai kebutuhan -->
    </select>
    <x-input-error :messages="$errors->get('program_studi')" />
</div>


            <div class="col-md-6">
                <x-input-label for="alamat" :value="__('Alamat')" />
                <x-text-input id="alamat" name="alamat" type="text" :value="old('alamat', $user->alamat)" required />
                <x-input-error :messages="$errors->get('alamat')" />
            </div>

            <div class="col-md-6">
                <x-input-label for="kontak" :value="__('Kontak')" />
                <x-text-input id="kontak" name="kontak" type="text" :value="old('kontak', $user->kontak)" required />
                <x-input-error :messages="$errors->get('kontak')" />
            </div>
        </div>

        <!-- Save Button -->
        <div class="d-flex align-items-center gap-2 mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-muted p-0 m-0">
                    {{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

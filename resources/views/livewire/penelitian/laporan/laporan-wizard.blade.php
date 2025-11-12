<div>

    <div class=" p-5">

        {{-- 🧭 Step Indicator --}}
        <livewire:components.wizard-steps.step-indicator :step="$step" :key="'step-indicator-' . $step" :labels="[
            1 => ['label' => 'informasi umum', 'icon' => 'bi-person-badge'],
            2 => ['label' => 'informasi laporan', 'icon' => 'bi-people'],
            3 => ['label' => 'Dokumen', 'icon' => 'bi-file-earmark-text'],
            4 => ['label' => 'Preview', 'icon' => 'bi-eye'],
        ]" />

        {{-- 💡 Step Content --}}
        <div class="card border-0 rounded-4 p-5 mb-4">

            {{-- Step 1 --}}
            <div style="{{ $step !== 1 ? 'display:none;' : '' }}">
                @include('livewire.penelitian.laporan.steps.informasi-umum')
            </div>

            {{-- Step 2 --}}
            <div style="{{ $step !== 2 ? 'display:none;' : '' }}">
                @include('livewire.penelitian.laporan.steps.informasi-laporan')
            </div>

            {{-- Step 3 --}}
            <div style="{{ $step !== 3 ? 'display:none;' : '' }}">
                @include('livewire.penelitian.laporan.steps.dokumen')
            </div>

            {{-- Step 4 --}}
            <div style="{{ $step !== 4 ? 'display:none;' : '' }}">
                @include('livewire.penelitian.laporan.steps.preview')
            </div>
        </div>

       

        {{-- 🔔 Flash & Validation Messages --}}
        <div class="mt-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>
  {{-- 🔘 Navigation Buttons --}}
        <div class="d-flex justify-content-between align-items-center">
            <button wire:click="prevStep" class="btn btn-outline-secondary px-4 rounded-pill shadow-sm"
                @disabled($step === 1)>
                ← Sebelumnya
            </button>

            <button wire:click="{{ $step < 4 ? 'nextStep' : 'submit' }}"
                class="btn rounded-pill px-5 fw-semibold shadow-sm 
                    {{ $step < 4 ? 'btn-primary' : 'btn-success' }}">
                {{ $step < 4 ? 'Berikutnya →' : 'Simpan Laporan' }}
            </button>
        </div>

</div>

<div class="container py-5">

    {{-- Step Indicator --}}
    <livewire:components.wizard-steps.step-indicator :step="$step"  :key="'step-indicator-'.$step" :labels="[
        1 => ['label' => 'Identitas', 'icon' => 'bi-person-badge'],
        2 => ['label' => 'Anggota', 'icon' => 'bi-people'],
        3 => ['label' => 'Mitra', 'icon' => 'bi-building'],
        4 => ['label' => 'Dokumen', 'icon' => 'bi-file-earmark-text'],
        5 => ['label' => 'preview', 'icon' => 'bi-file-earmark-text'],
    ]" />


    {{-- Step Content --}}
    <div class="card  border-0 rounded-4 p-5 mb-4">
        <div style="{{ $step !== 1 ? 'display:none;' : '' }}">
            @include('livewire.pengabdian.proposal.steps.identitas')
        </div>
        <div style="{{ $step !== 2 ? 'display:none;' : '' }}">
            @include('livewire.pengabdian.proposal.steps.anggota')
        </div>
        <div style="{{ $step !== 3 ? 'display:none;' : '' }}">
            @include('livewire.pengabdian.proposal.steps.mitra')
        </div>
        <div style="{{ $step !== 4 ? 'display:none;' : '' }}">
            @include('livewire.pengabdian.proposal.steps.dokumen')
        </div>
        <div style="{{ $step !== 5 ? 'display:none;' : '' }}">
            @include('livewire.pengabdian.proposal.steps.preview')
        </div>
    </div>

    {{-- Navigation --}}
    <div class="d-flex justify-content-between align-items-center">
        <button wire:click="prevStep" class="btn btn-outline-secondary px-4 rounded-pill shadow-sm"
            @disabled($step === 1)>
            ← Sebelumnya
        </button>

        <button wire:click="{{ $step < 5 ? 'nextStep' : 'submit' }}"
            class="btn rounded-pill px-5 fw-semibold shadow-sm 
            {{ $step < 5 ? 'btn-primary' : 'btn-success' }}">
            {{ $step < 5 ? 'Berikutnya →' : 'Simpan Proposal' }}
        </button>
    </div>

    {{-- Flash / Validation Messages --}}
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

    @push('style')
        <style>
            .bg-gradient {
                background: linear-gradient(90deg, #007bff, #00c6ff);
            }

            .step-item {
                min-width: 70px;
            }
        </style>
    @endpush
</div>

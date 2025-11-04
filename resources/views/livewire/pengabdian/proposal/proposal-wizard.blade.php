<div class="container py-5">

    {{-- Step Indicator --}}
    <div class="mb-5 position-relative">
        <div class="progress rounded-pill" style="height: 10px;">
            <div class="progress-bar bg-gradient" role="progressbar"
                 style="width: {{ ($step / 4) * 100 }}%; transition: width 0.4s ease;">
            </div>
        </div>

        <div class="d-flex justify-content-between mt-3 text-center small fw-semibold">
            @php
                $labels = [
                    1 => ['label' => 'Identitas', 'icon' => 'bi-person-badge'],
                    2 => ['label' => 'Anggota', 'icon' => 'bi-people'],
                    3 => ['label' => 'Mitra', 'icon' => 'bi-building'],
                    4 => ['label' => 'Dokumen', 'icon' => 'bi-file-earmark-text']
                ];
            @endphp

            @foreach ($labels as $i => $info)
                <div class="step-item flex-fill">
                    <div class="rounded-circle mx-auto mb-1 
                        {{ $step >= $i ? 'bg-primary text-white shadow' : 'bg-light text-secondary border' }}"
                        style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">
                        <i class="bi {{ $info['icon'] }}"></i>
                    </div>
                    <div class="{{ $step === $i ? 'text-primary' : 'text-muted' }}">
                        {{ $info['label'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

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
    </div>

    {{-- Navigation --}}
    <div class="d-flex justify-content-between align-items-center">
        <button wire:click="prevStep" class="btn btn-outline-secondary px-4 rounded-pill shadow-sm"
                @disabled($step === 1)>
            ← Sebelumnya
        </button>

        <button 
            wire:click="{{ $step < 4 ? 'nextStep' : 'submit' }}" 
            class="btn rounded-pill px-5 fw-semibold shadow-sm 
            {{ $step < 4 ? 'btn-primary' : 'btn-success' }}">
            {{ $step < 4 ? 'Berikutnya →' : 'Simpan Proposal' }}
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



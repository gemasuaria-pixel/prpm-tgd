<div>
    {{-- Indikator Step --}}
    <div class="d-flex justify-content-between mb-4">
        @foreach ([1, 2, 3, 4] as $s)
            <div class="flex-fill text-center py-2 rounded-pill
                {{ $step === $s ? 'bg-primary text-white fw-bold' : 'bg-light' }}">
                Langkah {{ $s }}
            </div>
        @endforeach
    </div>

    {{-- Konten Step --}}
<div class="card shadow-sm border-0 rounded-4 p-4">
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


    {{-- Navigasi --}}

        <button wire:click="prevStep" class="btn btn-outline-secondary" @disabled($step === 1)>
            ← Sebelumnya
        </button>

       
           <button 
    wire:click="{{ $step < 4 ? 'nextStep' : 'submit' }}" 
    class="btn {{ $step < 4 ? 'btn-primary' : 'btn-success' }}"
>
    {{ $step < 4 ? 'Berikutnya →' : 'Simpan Proposal' }}
</button>

  

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="alert alert-success mt-3 rounded-4">
            {{ session('success') }}
        </div>
    @endif
</div>

<div>
    <h6 class="fw-bold border-bottom pb-2">Informasi Laporan</h6>

    <div class="mb-3">
        <label class="form-label">Judul Laporan Penelitian</label>
        <input type="text" class="form-control" wire:model.defer="laporan.judul" required>
        @error('laporan.judul') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Kata Kunci</label>
        <input type="text" class="form-control" wire:model.defer="laporan.kata_kunci" placeholder="AI, Data Mining">
        @error('laporan.kata_kunci') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Metode Penelitian</label>
        <input type="text" class="form-control" wire:model.defer="laporan.metode_penelitian">
        @error('laporan.metode_penelitian') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Abstrak</label>
        <textarea class="form-control" wire:model.defer="laporan.abstrak" rows="4"></textarea>
        @error('laporan.abstrak') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Ringkasan Laporan</label>
        <textarea class="form-control" wire:model.defer="laporan.ringkasan_laporan" rows="4"></textarea>
        @error('laporan.ringkasan_laporan') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
</div>

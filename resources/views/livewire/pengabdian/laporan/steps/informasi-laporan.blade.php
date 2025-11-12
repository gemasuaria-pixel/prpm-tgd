<div>
    <h5 class="fw-bold mb-4 text-primary">E. Informasi Laporan</h5>

    <div class="mb-3">
        <label class="form-label">Judul Laporan Pengabdian</label>
        <input type="text" wire:model.defer="laporan.judul" class="form-control" required>
        @error('laporan.judul') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">tahun pelaksanaan</label>
        <input type="number" wire:model.defer="laporan.tahun_pelaksanaan" class="form-control" required>
        @error('laporan.tahun_pelaksanaan') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Ringkasan</label>
        <textarea wire:model.defer="laporan.ringkasan" class="form-control" rows="4"
                  placeholder="Tuliskan ringkasan kegiatan"></textarea>
        @error('laporan.ringkasan') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
</div>

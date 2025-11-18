<div>
    <h5 class="fw-bold mb-4 text-primary">E. Informasi Laporan</h5>

    <!-- Judul -->
    <div class="mb-3">
        <label class="form-label">Judul Laporan Pengabdian</label>
        <input type="text" wire:model.defer="laporan.judul" class="form-control" required>
        @error('laporan.judul') <small class="text-danger">{{ $message }}</small> @enderror
    </div>


    <!-- Kata Kunci -->
    <div class="mb-3">
        <label class="form-label">Kata Kunci</label>
        <input type="text" wire:model.defer="laporan.kata_kunci" class="form-control"
               placeholder="Contoh: pemberdayaan, UMKM, edukasi" required>
        @error('laporan.kata_kunci') <small class="text-danger">{{ $message }}</small> @enderror
    </div>



    <!-- Ringkasan -->
    <div class="mb-3">
        <label class="form-label">Ringkasan</label>
        <textarea wire:model.defer="laporan.ringkasan_laporan" class="form-control" rows="4"
                  placeholder="Tuliskan ringkasan kegiatan"></textarea>
        @error('laporan.ringkasan_laporan') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
</div>

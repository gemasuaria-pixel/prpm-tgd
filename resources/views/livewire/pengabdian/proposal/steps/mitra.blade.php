<div>
    <h5 class="mb-3">Informasi Mitra</h5>

    <div class="row g-3">
        {{-- Nama Mitra --}}
        <div class="col-md-6">
            <label>Nama Mitra *</label>
            <input type="text" wire:model.lazy="mitra.nama_mitra"
                   class="form-control @error('mitra.nama_mitra') is-invalid @enderror" required>
            @error('mitra.nama_mitra')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Jenis Mitra --}}
        <div class="col-md-6">
            <label>Jenis Mitra *</label>
            <select wire:model.lazy="mitra.jenis_mitra"
                    class="form-select @error('mitra.jenis_mitra') is-invalid @enderror" required>
                <option value="" disabled selected>Pilih Jenis</option>
                <option value="Industri">Industri</option>
                <option value="Pemerintah">Pemerintah</option>
                <option value="Komunitas">Komunitas</option>
                <option value="Lembaga Pendidikan">Lembaga Pendidikan</option>
                <option value="UMKM">UMKM</option>
            </select>
            @error('mitra.jenis_mitra')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Alamat Mitra --}}
        <div class="col-md-12">
            <label>Alamat Mitra *</label>
            <input type="text" wire:model.lazy="mitra.alamat_mitra"
                   class="form-control @error('mitra.alamat_mitra') is-invalid @enderror" required>
            @error('mitra.alamat_mitra')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Kontak Mitra --}}
        <div class="col-md-12">
            <label>Kontak Mitra *</label>
            <input type="text" wire:model.lazy="mitra.kontak_mitra"
                   class="form-control @error('mitra.kontak_mitra') is-invalid @enderror" required>
            @error('mitra.kontak_mitra')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Pernyataan Kebutuhan --}}
        <div class="col-md-12">
            <label>Pernyataan Kebutuhan</label>
            <textarea wire:model.lazy="mitra.pernyataan_kebutuhan"
                      class="form-control @error('mitra.pernyataan_kebutuhan') is-invalid @enderror"></textarea>
            @error('mitra.pernyataan_kebutuhan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

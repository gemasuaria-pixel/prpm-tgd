<div>
    <h5 class="mb-3">Informasi Mitra</h5>

    <div class="row g-3">
        <div class="col-md-6">
            <label>Nama Mitra *</label>
            <input type="text" wire:model="mitra.nama_mitra" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Jenis Mitra *</label>
            <select wire:model="mitra.jenis_mitra" class="form-select" required>
                <option disabled selected>Pilih Jenis</option>
                <option value="Industri">Industri</option>
                <option value="Pemerintah">Pemerintah</option>
                <option value="Komunitas">Komunitas</option>
                <option value="Lembaga Pendidikan">Lembaga Pendidikan</option>
                <option value="UMKM">UMKM</option>
            </select>
        </div>
        <div class="col-md-12">
            <label>Alamat Mitra *</label>
            <input type="text" wire:model="mitra.alamat_mitra" class="form-control" required>
        </div>
        <div class="col-md-12">
            <label>Kontak Mitra *</label>
            <input type="text" wire:model="mitra.kontak_mitra" class="form-control" required>
        </div>
        <div class="col-md-12">
            <label>Pernyataan Kebutuhan</label>
            <textarea wire:model="mitra.pernyataan_kebutuhan" class="form-control"></textarea>
        </div>
    </div>
</div>

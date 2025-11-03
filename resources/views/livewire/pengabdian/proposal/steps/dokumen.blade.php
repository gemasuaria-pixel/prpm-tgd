<div>
    <h5 class="mb-3">Dokumen & Abstrak</h5>

    <div class="row g-3">
        <div class="col-md-12">
            <label>Abstrak</label>
            <textarea wire:model="dokumen.abstrak" class="form-control"></textarea>
        </div>

        <div class="col-md-12">
            <label>Kata Kunci</label>
            <input type="text" wire:model="dokumen.kata_kunci" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label>Luaran Tambahan Dijanjikan *</label>
            <select wire:model="dokumen.luaran_tambahan_dijanjikan" class="form-select" required>
                <option disabled selected>Pilih Jenis</option>
                <option value="jurnal">Jurnal</option>
                <option value="program">Program</option>
                <option value="buku">Buku</option>
            </select>
        </div>

        <div class="col-md-12">
            <label>Upload Proposal *</label>
            <input type="file" wire:model="dokumen.file_path" class="form-control" required>
            @error('document') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-check mt-3">
        <input type="checkbox" wire:model="dokumen.syarat_ketentuan" class="form-check-input" required>
        <label class="form-check-label">Saya menyatakan data yang saya masukkan benar.</label>
    </div>
</div>

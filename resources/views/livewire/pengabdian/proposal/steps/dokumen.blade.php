<div>
    <h5 class="mb-3">Dokumen & Abstrak</h5>

    <div class="row g-3">
        {{-- Abstrak --}}
        <div class="col-md-12">
            <label>Abstrak</label>
            <textarea wire:model.lazy="dokumen.abstrak"
                      class="form-control @error('dokumen.abstrak') is-invalid @enderror"></textarea>
            @error('dokumen.abstrak')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Kata Kunci --}}
        <div class="col-md-12">
            <label>Kata Kunci *</label>
            <input type="text" wire:model.lazy="dokumen.kata_kunci"
                   class="form-control @error('dokumen.kata_kunci') is-invalid @enderror" required>
            @error('dokumen.kata_kunci')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Luaran Tambahan Dijanjikan --}}
        <div class="col-md-6">
            <label>Luaran Tambahan Dijanjikan *</label>
            <select wire:model.lazy="dokumen.luaran_tambahan_dijanjikan"
                    class="form-select @error('dokumen.luaran_tambahan_dijanjikan') is-invalid @enderror" required>
                <option value="" disabled selected>Pilih Jenis</option>
                <option value="jurnal">Jurnal</option>
                <option value="program">Program</option>
                <option value="buku">Buku</option>
            </select>
            @error('dokumen.luaran_tambahan_dijanjikan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Upload Proposal --}}
        <div class="col-md-12">
            <label>Upload Proposal *</label>
            <input type="file" wire:model="dokumen.file_path"
                   class="form-control @error('dokumen.file_path') is-invalid @enderror" required>
            @error('dokumen.file_path')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

   
</div>

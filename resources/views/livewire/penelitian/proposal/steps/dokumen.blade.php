<div>
    <h5 class="fw-bold mb-3">C. Dokumen Penelitian</h5>

    <div class="mb-3">
        <label class="form-label">Kata Kunci</label>
        <input 
            type="text" 
            wire:model="dokumen.kata_kunci" 
            class="form-control @error('dokumen.kata_kunci') is-invalid @enderror"
        >
        @error('dokumen.kata_kunci')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Abstrak</label>
        <textarea 
            wire:model="dokumen.abstrak" 
            class="form-control @error('dokumen.abstrak') is-invalid @enderror" 
            rows="4"
        ></textarea>
        @error('dokumen.abstrak')
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

    <div class="mb-3">
        <label class="form-label">Luaran Tambahan</label>
        <select 
            wire:model="dokumen.luaran_tambahan_dijanjikan" 
            class="form-select @error('dokumen.luaran_tambahan_dijanjikan') is-invalid @enderror"
        >
            <option selected disabled>-- Pilih --</option>
            <option value="Publikasi Jurnal">Publikasi Jurnal</option>
            <option value="Hak Kekayaan Intelektual">Hak Kekayaan Intelektual</option>
            <option value="Buku Ajar">Buku Ajar</option>
        </select>
        @error('dokumen.luaran_tambahan_dijanjikan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


</div>

<div>
    <h6 class="fw-bold border-bottom pb-2">D. Upload Dokumen & E. Luaran</h6>

    <div class="mb-3">
        <label class="form-label">File Laporan (PDF / DOCX) <span class="text-danger">*</span></label>
        <input type="file" class="form-control" wire:model="file_path">
        @error('file_path') <small class="text-danger">{{ $message }}</small> @enderror
        <div wire:loading wire:target="file_path">Uploading...</div>
    </div>

    <hr>

    <div class="mb-3">
        <label class="form-label">Link Jurnal</label>
        @foreach ($luaran['jurnal'] as $idx => $val)
            <div class="d-flex mb-2">
                <input type="url" class="form-control" wire:model="luaran.jurnal.{{ $idx }}" placeholder="https://...">
                <button type="button" class="btn btn-outline-danger ms-2" wire:click="removeLuaran('jurnal', {{ $idx }})">Hapus</button>
            </div>
        @endforeach
        <button type="button" class="btn btn-sm btn-outline-primary mt-1" wire:click="addLuaran('jurnal')">Tambah Link Jurnal</button>
    </div>

    <div class="mb-3">
        <label class="form-label">Link Video</label>
        @foreach ($luaran['video'] as $idx => $val)
            <div class="d-flex mb-2">
                <input type="url" class="form-control" wire:model="luaran.video.{{ $idx }}" placeholder="https://...">
                <button type="button" class="btn btn-outline-danger ms-2" wire:click="removeLuaran('video', {{ $idx }})">Hapus</button>
            </div>
        @endforeach
        <button type="button" class="btn btn-sm btn-outline-primary mt-1" wire:click="addLuaran('video')">Tambah Link Video</button>
    </div>

   
</div>

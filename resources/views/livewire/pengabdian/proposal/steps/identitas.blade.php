<div>
    <h5 class="mb-3">Identitas Proposal</h5>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Judul Pengabdian *</label>
            <input type="text" wire:model.lazy="identitas.judul"
                   class="form-control @error('identitas.judul') is-invalid @enderror">
            @error('identitas.judul')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Tahun Pelaksanaan *</label>
            <input type="number" wire:model.lazy="identitas.tahun_pelaksanaan"
                   class="form-control @error('identitas.tahun_pelaksanaan') is-invalid @enderror">
            @error('identitas.tahun_pelaksanaan')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Rumpun Ilmu</label>
            <input type="text" wire:model.lazy="identitas.rumpun_ilmu"
                    class="form-control @error('identitas.rumpun_ilmu') is-invalid @enderror">
                    @error('identitas.rumpun_ilmu')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Bidang Pengabdian *</label>
            <select wire:model.lazy="identitas.bidang_pengabdian"
                    class="form-select @error('identitas.bidang_pengabdian') is-invalid @enderror">
                <option value="">-- Pilih Bidang --</option>
                <option value="Teknologi Tepat Guna">Teknologi Tepat Guna</option>
                <option value="Pendidikan dan Literasi">Pendidikan dan Literasi</option>
                <option value="Kesehatan dan Lingkungan">Kesehatan dan Lingkungan</option>
                <option value="Ekonomi Kreatif dan Kewirausahaan">Ekonomi Kreatif dan Kewirausahaan</option>
                <option value="Sosial dan Budaya">Sosial dan Budaya</option>
            </select>
            @error('identitas.bidang_pengabdian')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="mt-4">
        <label class="form-label">Ketua Pengusul</label>
        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
    </div>


    <style>
        .is-invalid {
            border-color: #dc3545 !important;
            background-color: #fff5f5;
        }
    </style>
</div>

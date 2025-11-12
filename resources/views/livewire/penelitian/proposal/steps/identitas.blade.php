<div class="row g-3">
    <h5 class="fw-bold mb-3">A. Identitas Proposal</h5>

    {{-- Judul --}}
    <div class="col-md-6">
        <label class="form-label">Judul Proposal <span class="text-danger">*</span></label>
        <input type="text" wire:model="identitas.judul"
            class="form-control @error('identitas.judul') is-invalid @enderror"
            placeholder="Contoh: Sistem Data Mining pada Web 5.0">
        @error('identitas.judul')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Tahun Pelaksanaan --}}
    <div class="col-md-6">
        <label class="form-label">Tahun Pelaksanaan <span class="text-danger">*</span></label>
        <input type="number" wire:model="identitas.tahun_pelaksanaan"
            class="form-control @error('identitas.tahun_pelaksanaan') is-invalid @enderror" placeholder="2025">
        @error('identitas.tahun_pelaksanaan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Rumpun Ilmu --}}
    <div class="col-md-6">
        <label class="form-label">Rumpun Ilmu</label>
        <input type="text" wire:model="identitas.rumpun_ilmu"
            class="form-control @error('identitas.rumpun_ilmu') is-invalid @enderror" placeholder="Contoh: Manajemen">
        @error('identitas.rumpun_ilmu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Bidang Penelitian --}}
    <div class="col-md-6">
        <label class="form-label">Bidang Penelitian</label>
        <select wire:model="identitas.bidang_penelitian"
            class="form-select @error('identitas.bidang_penelitian') is-invalid @enderror">
            <option value="">-- Pilih Bidang --</option>
            <option value="Teknologi Informasi">Teknologi Informasi</option>
            <option value="Sistem Informasi">Sistem Informasi</option>
            <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
            <option value="Kecerdasan Buatan">Kecerdasan Buatan</option>
            <option value="Jaringan Komputer">Jaringan Komputer</option>
        </select>
        @error('identitas.bidang_penelitian')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Ketua Pengusul --}}
    <div class="col-md-12">
        <label class="form-label">Ketua Pengusul</label>
        <input type="text" class="form-control" value="{{ Auth::user()->full_name }}" readonly>
    </div>

</div>

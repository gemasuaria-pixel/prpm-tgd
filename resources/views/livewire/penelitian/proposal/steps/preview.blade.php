<div class="container">
    <h4 class="fw-bold mb-4">
        <i class="bi bi-eye me-2 text-primary"></i>Preview Proposal Pengabdian
    </h4>

    {{-- Identitas Proposal --}}
    <div class="mb-4">
        <h5 class="text-secondary mb-3"><i class="bi bi-person-badge me-2"></i>Identitas Proposal</h5>
        <table class="table table-bordered small">
            <tr>
                <th>Judul</th>
                <td>{{ $identitas['judul'] ?: '-' }}</td>
            </tr>
            <tr>
                <th>Tahun Pelaksanaan</th>
                <td>{{ $identitas['tahun_pelaksanaan'] ?: '-' }}</td>
            </tr>
            <tr>
                <th>Rumpun Ilmu</th>
                <td>{{ $identitas['rumpun_ilmu'] ?: '-' }}</td>
            </tr>
            <tr>
                <th>Bidang Pengabdian</th>
                <td>{{ $identitas['bidang_penelitian'] ?: '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- Anggota --}}
    <div class="mb-4">
        <h5 class="text-secondary mb-3"><i class="bi bi-people me-2"></i>Anggota Tim</h5>
        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-semibold text-muted mb-2">Dosen</h6>
                @forelse($anggota_dosen as $dosen)
                    <div class="border rounded-3 p-2 mb-2">
                        <strong>{{ $dosen['name'] ?? '-' }}</strong><br>
                        <small>NIDN: {{ $dosen['nidn'] ?? '-' }}</small>
                    </div>
                @empty
                    <p class="text-muted small fst-italic">Tidak ada dosen ditambahkan.</p>
                @endforelse
            </div>
        </div>
    </div>

   
    {{-- Dokumen --}}
    <div class="mb-4">
        <h5 class="text-secondary mb-3"><i class="bi bi-file-earmark-text me-2"></i>Dokumen</h5>
        <table class="table table-bordered small">
            <tr>
                <th>Abstrak</th>
                <td>{{ Str::limit($dokumen['abstrak'] ?? '-', 300) }}</td>
            </tr>
            <tr>
                <th>Kata Kunci</th>
                <td>{{ $dokumen['kata_kunci'] ?? '-' }}</td>
            </tr>
            <tr>
                <th>Luaran Tambahan</th>
                <td>{{ ucfirst($dokumen['luaran_tambahan_dijanjikan'] ?? '-') }}</td>
            </tr>
            <tr>
                <th>File Proposal</th>
                <td>
                    @if ($dokumen['file_path'])
                        <span class="badge bg-success">Sudah diunggah</span>
                    @else
                        <span class="badge bg-secondary">Belum diunggah</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    {{-- Konfirmasi --}}
    <div class="alert alert-info rounded-4 shadow-sm">
        <i class="bi bi-info-circle me-2"></i>
        Pastikan semua data sudah benar sebelum mengirim proposal.
    </div>
    
     {{-- Syarat & Ketentuan --}}
    <div class="form-check mt-3">
        <input type="checkbox" wire:model.lazy="syarat_ketentuan"
               class="form-check-input @error('syarat_ketentuan') is-invalid @enderror" required>
        <label class="form-check-label">Saya menyatakan data yang saya masukkan benar.</label>
        @error('syarat_ketentuan')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>

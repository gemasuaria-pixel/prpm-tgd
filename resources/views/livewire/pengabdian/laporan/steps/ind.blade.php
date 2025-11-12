@extends('layouts.main')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<style>
    /* Card section spacing */
    .form-section {
        margin-top: 2rem;
        padding: 1.5rem;
        border-radius: 0.75rem;
        background-color: #f8f9fa;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .form-section h6 {
        font-size: 1.05rem;
        margin-bottom: 1rem;
        color: #495057;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .input-group-text {
        width: 130px;
    }

    .btn-add-link {
        font-size: 0.85rem;
    }
</style>
@endpush

@section('content')
<main class="app-main">
    <div class="app-content">
        <div class="container">
            <x-breadcrumbs>Upload Laporan Pengabdian</x-breadcrumbs>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dosen.pengabdian.laporan.store', $proposal) }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Informasi Proposal --}}
                <div class="form-section">
                    <h6>A. Informasi Proposal</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Judul Proposal</label>
                            <div class="fw-semibold">{{ $proposal->judul }}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Tahun Pelaksanaan</label>
                            <div class="fw-semibold">{{ $proposal->tahun_pelaksanaan }}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Rumpun Ilmu</label>
                            <div class="fw-semibold">{{ $proposal->rumpun_ilmu }}</div>
                        </div>
                    </div>
                </div>

                {{-- Anggota Dosen --}}
                <div class="form-section">
                    <h6>B. Anggota Dosen</h6>
                    <table class="table table-bordered table-hover mt-2">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>NIDN</th>
                                <th>Alamat</th>
                                <th>Kontak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proposal->anggotaDosen as $anggota)
                                <tr>
                                    <td>{{ $anggota->user->name }}</td>
                                    <td>{{ $anggota->user->nidn ?? '-' }}</td>
                                    <td>{{ $anggota->user->alamat ?? '-' }}</td>
                                    <td>{{ $anggota->user->kontak ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Anggota Mahasiswa --}}
                <div class="form-section">
                    <h6>C. Anggota Mahasiswa</h6>
                    <table class="table table-bordered table-hover mt-2">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Program Studi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proposal->anggota as $anggota)
                                <tr>
                                    <td>{{ $anggota->nama }}</td>
                                    <td>{{ $anggota->nim }}</td>
                                    <td>{{ $anggota->program_studi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Informasi Mitra --}}
                <div class="form-section">
                    <h6>D. Informasi Mitra</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nama Mitra</label>
                            <div class="fw-semibold">{{ $proposal->nama_mitra ?? '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jenis Mitra</label>
                            <div class="fw-semibold">{{ $proposal->jenis_mitra ?? '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Pimpinan Mitra</label>
                            <div class="fw-semibold">{{ $proposal->pimpinan_mitra ?? '-' }}</div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Alamat Mitra</label>
                            <div class="fw-semibold">{{ $proposal->alamat_mitra ?? '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kontak Mitra</label>
                            <div class="fw-semibold">{{ $proposal->kontak_mitra ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Informasi Laporan --}}
                <div class="form-section">
                    <h6>E. Informasi Laporan</h6>
                    <div class="mb-3">
                        <label class="form-label">Judul Laporan Pengabdian</label>
                        <input type="text" name="judul" class="form-control"
                               value="{{ old('judul', $proposal->judul) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ringkasan</label>
                        <textarea name="ringkasan" class="form-control" rows="4"
                                  placeholder="Tuliskan ringkasan kegiatan">{{ old('ringkasan') }}</textarea>
                    </div>
               
                </div>

                {{-- Upload Dokumen --}}
                <div class="form-section">
                    <h6>F. Upload Dokumen</h6>
                    <div class="mb-3">
                        <label class="form-label">File Laporan <span class="text-danger">*</span></label>
                        <input type="file" name="file_laporan" class="form-control" required>
                        <div class="form-text">Format PDF/DOCX, max 25 MB</div>
                    </div>
                </div>

                {{-- Luaran --}}
                <div class="form-section">
                    <h6>G. Luaran Pengabdian</h6>
                    <div class="mb-3">
                        <label class="form-label">Link Jurnal</label>
                        <div id="jurnalContainer">
                            <input type="url" name="luaran[jurnal][]" class="form-control mb-2" placeholder="https://...">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-add-link" onclick="addLink('jurnal')">+ Tambah Link Jurnal</button>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link Video</label>
                        <div id="videoContainer">
                            <input type="url" name="luaran[video][]" class="form-control mb-2" placeholder="https://...">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-add-link" onclick="addLink('video')">+ Tambah Link Video</button>
                    </div>
                </div>

                {{-- Pernyataan --}}
                <div class="form-check mt-4 mb-3">
                    <input class="form-check-input" type="checkbox" id="pernyataan" name="pernyataan" required>
                    <label class="form-check-label small" for="pernyataan">
                        Saya menyatakan bahwa informasi dan dokumen yang saya serahkan adalah benar.
                    </label>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end gap-2 mb-5">
                    <button type="reset" class="btn btn-outline-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Laporan</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<script>
function addLink(type) {
    const container = document.getElementById(type + 'Container');
    const input = document.createElement('input');
    input.type = 'url';
    input.name = `luaran[${type}][]`;
    input.className = 'form-control mb-2';
    input.placeholder = 'https://...';
    container.appendChild(input);
}
</script>

@if (session('success') || session('status'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') ?? session('status') }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@elseif (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '{{ session('error') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif
@endpush

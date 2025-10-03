@extends('layouts.main')

@section('content')
    <!--begin::App Main-->
    <main class="app-main">

        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->

            <div class="container ">
                <x-breadcrumbs>Usulan Penelitian</x-breadcrumbs>
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start  border-bottom">
                                    <div>
                                        <h4 class="mb-1">Formulir Usulan Penelitian Masyarakat</h4>
                                        <p class="small text-muted mb-0">Formulir ini dibuat untuk memenuhi pertanyaan
                                            terkait pengusulan proposal Penelitian. Harap untuk melengkapi semua pertanyaan
                                            yang ada</p>
                                    </div>

                                </div>


                                <form action="{{ route('user.usulanProposal-pengabdian') }}" method="POST"
                                    enctype="multipart/form-data" class="needs-validation" novalidate>
                                    @csrf

                                    <h6 class="mb-3">A. Informasi Umum</h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-12">
                                            <label class="form-label">Judul Pengabdian <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="judul" class="form-control"
                                                placeholder="Contoh: Penerapan Penjualan..." required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tahun Pelaksanaan <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="tahun" class="form-control"
                                                placeholder="Contoh: 2025" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Rumpun Ilmu <span class="text-danger">*</span></label>
                                            <input type="text" name="rumpun" class="form-control"
                                                placeholder="Contoh: Manajemen" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Ketua Pengusul <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="ketua" class="form-control"
                                                placeholder="Nama Ketua" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Anggota (Dosen)</label>
                                            <input type="text" name="anggota_dosen[]" class="form-control mb-2"
                                                placeholder="Nama anggota dosen">
                                            <div id="dosenList"></div>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-1"
                                                onclick="addDosen()">+ Tambah</button>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Anggota (Mahasiswa)</label>
                                            <input type="text" name="anggota_mahasiswa[]" class="form-control mb-2"
                                                placeholder="Nama anggota mahasiswa">
                                            <div id="mahasiswaList"></div>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-1"
                                                onclick="addMahasiswa()">+ Tambah</button>
                                        </div>
                                    </div>

                                    <hr>

                                    <h6 class="mb-3">B. Informasi Mitra</h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Mitra <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_mitra" class="form-control"
                                                placeholder="Contoh: PT Mencari Cinta" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jenis Kelompok Mitra <span
                                                    class="text-danger">*</span></label>
                                            <select name="jenis_mitra" class="form-select" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="kelompok_tani">Kelompok Tani</option>
                                                <option value="kelompok_ukm">Kelompok UKM</option>
                                                <option value="kelompok_masyarakat">Kelompok Masyarakat</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Alamat Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="alamat_mitra" class="form-control"
                                                placeholder="Jl. Sukoharjo..." required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Kontak Mitra <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="kontak_mitra" class="form-control"
                                                placeholder="+628xxxx" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Pimpinan Mitra <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="pimpinan_mitra" class="form-control"
                                                placeholder="Budiman Sanoyo, S.E" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jumlah Anggota Kelompok <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="jumlah_anggota" class="form-control"
                                                placeholder="Contoh: 6 Orang" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Pernyataan Kebutuhan Oleh Mitra <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="kebutuhan_mitra" class="form-control" rows="3" placeholder="Deskripsikan kebutuhan mitra..."
                                                required></textarea>
                                        </div>
                                    </div>

                                    <hr>

                                    <h6 class="mb-3">C. Upload Dokumen</h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-8">
                                            <label class="form-label">File Proposal Pengabdian <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="file_proposal" class="form-control"
                                                accept=".pdf,.doc,.docx" required>
                                            <div class="small-muted mt-1">File maks 25 MB dalam format PDF atau DOCX.</div>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end">
                                            <a href="{{ asset('panduan_pengabdian.pdf') }}"
                                                class="btn btn-outline-secondary w-100" download>Unduh Panduan</a>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Luaran Tambahan Dijanjikan</label>
                                        <select name="luaran" class="form-select">
                                            <option value="">-- Pilih --</option>
                                            <option value="artikel_jurnal">Artikel Jurnal</option>
                                            <option value="buku">Buku</option>
                                            <option value="produk">Produk/Prototype</option>
                                        </select>
                                    </div>

                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" name="pernyataan" required>
                                        <label class="form-check-label small-muted">
                                            Saya menyatakan bahwa informasi dan dokumen yang saya serahkan adalah benar.
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-outline-secondary">Tambah ke Draft</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                                   <script>
        function addDosen() {
            document.getElementById('dosenList').innerHTML +=
                '<input type="text" name="anggota_dosen[]" class="form-control mb-2" placeholder="Nama anggota dosen">';
        }

        function addMahasiswa() {
            document.getElementById('mahasiswaList').innerHTML +=
                '<input type="text" name="anggota_mahasiswa[]" class="form-control mb-2" placeholder="Nama anggota mahasiswa">';
        }
    </script>
                                <div class=" p-4 border-bottom">
                                    <!-- Syarat Ketua Pengusul -->
                                    <!-- Judul Toggle -->


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end::Container-->
    </main>
    <!--end::App Content-->
@endsection

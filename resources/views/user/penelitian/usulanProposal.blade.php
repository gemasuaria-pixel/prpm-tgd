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
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-start p-4 border-bottom">
                                    <div>
                                        <h4 class="mb-1">Formulir Usulan Penelitian Masyarakat</h4>
                                        <p class="small text-muted mb-0">Formulir ini dibuat untuk memenuhi pertanyaan
                                            terkait pengusulan proposal Penelitian. Harap untuk melengkapi semua pertanyaan
                                            yang ada</p>
                                    </div>

                                </div>


                                <div class="container my-4">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body p-4">
                                            <h4 class="mb-3 fw-semibold">Formulir Usulan Penelitian</h4>
                                            <p class="text-muted">Formulir ini dibuat untuk memenuhi persyaratan terkait
                                                pengusulan proposal Penelitian. Harap untuk melengkapi semua pertanyaan yang
                                                ada.</p>

                                            <form>
                                                <!-- Informasi Umum -->
                                                <h6 class="fw-bold mt-4">A. Informasi Umum</h6>
                                                <div class="row g-3 mt-1">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Judul Penelitian <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Sistem Data Mining pada Web 5.0 yang ...">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Tahun Pelaksanaan <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="2025">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Ketua Pengusul <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Dr. Dicky Noviandhisyah, S.Kom, M.Kom">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Rumpun Ilmu <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Contoh: Manajemen">
                                                    </div>
                                                    {{-- <div class="col-md-6">
                                                        <label class="form-label">Anggota Penelitian</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Isi Nama Anggota">
                                                    </div> --}}
                                                    <div class="col-md-6">
                                                        <label class="form-label">Bidang Penelitian</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Contoh: Teknologi Informasi">
                                                    </div>
                                                </div>

                                                <!-- Tambah Anggota -->
                                                <div class="card mt-4 border">
                                                    <div class="card-body">
                                                        <h6 class="fw-bold">Tambah Anggota Penelitian</h6>
                                                        <div class="row g-3 mt-1">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Nama Anggota</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Contoh: Dr. Ahmad Salem">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">NIDN Anggota</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="123443212">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Alamat Anggota</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Jl. Sukoharjo No 13 Kec. Medan Johor">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Kontak Anggota</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="08123456783">
                                                            </div>
                                                        </div>
                                                        <div class="text-end mt-3">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm">Batal</button>
                                                            <button type="button"
                                                                class="btn btn-primary btn-sm">Tambah</button>
                                                        </div>
                                                    </div>
                                                </div>
 <table class="table table-sm table-bordered mt-3 align-middle">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Nama</th>
                                                            <th>NIDN</th>
                                                            <th>Alamat</th>
                                                            <th>Kontak</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Contoh Anggota</td>
                                                            <td>123456789</td>
                                                            <td>Jl. Contoh No.1</td>
                                                            <td>08123456789</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- Informasi Penelitian -->
                                                <h6 class="fw-bold mt-4">B. Informasi Penelitian</h6>
                                                <div class="mb-3">
                                                    <label class="form-label">Kata Kunci <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Artificial Intelligence, Data Mining, Citra">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Abstrak <span class="text-danger">*(Maksimal
                                                            300 kata)</span></label>
                                                    <textarea class="form-control" rows="4" placeholder="Ketikkan Abstrak penelitian anda di sini"></textarea>
                                                </div>

                                                <!-- Upload Dokumen -->
                                                <h6 class="fw-bold mt-4">C. Upload Dokumen</h6>
                                                <div class="mb-3">
                                                    <label class="form-label">File Proposal Penelitian <span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" class="form-control">
                                                    <div class="form-text">File Maks 25 MB dan berformat PDF atau DOCX.
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Luaran Tambahan Dijanjikan</label>
                                                    <select class="form-select">
                                                        <option selected disabled>-- Pilih --</option>
                                                        <option>Publikasi Jurnal</option>
                                                        <option>Hak Kekayaan Intelektual</option>
                                                        <option>Buku Ajar</option>
                                                    </select>
                                                </div>

                                                <!-- Checkbox Pernyataan -->
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="pernyataan">
                                                    <label class="form-check-label" for="pernyataan">
                                                        Saya menyatakan bahwa informasi dan dokumen yang saya serahkan
                                                        adalah benar, dan saya siap menanggung konsekuensi apabila terjadi
                                                        pelanggaran.
                                                    </label>
                                                </div>

                                                <!-- Buttons -->
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn btn-outline-secondary">Tambah ke
                                                        Draft</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

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

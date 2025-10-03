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
                                            <label class="form-label">Rumpun Ilmu <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Contoh: Manajemen">
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
                                    <livewire:add-anggota>
                                    </livewire:add-anggota>
                                    <!-- Informasi Penelitian -->
                                    <h6 class="fw-bold mt-4">B. Informasi Penelitian</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Kata Kunci <span class="text-danger">*</span></label>
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
                                        <input class="form-check-input" type="checkbox" value="" id="pernyataan">
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
        <!--end::Container-->
    </main>
    <!--end::App Content-->
@endsection

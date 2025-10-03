@extends('layouts.main')

@section('content')
    <!--begin::App Main-->
    <main class="app-main">
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container py-4">
                <x-breadcrumbs>Laporan Penelitian</x-breadcrumbs>
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="card shadow-sm">
                            <div class="card-body p-0">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-start p-4 border-bottom">
                                    <div>
                                        <h4 class="mb-1">Formulir Upload Laporan Penelitian</h4>
                                        <p class="small text-muted mb-0">Formulir ini dibuat untuk memenuhi pertanyaan terkait pengunggahan laporan penelitian. Harap untuk melengkapi semua pertanyaan yang ada</p>
                                    </div>
                                </div>

                                <!-- Form -->
                                <form id="laporanForm" class="row g-0 needs-validation" novalidate>
                                    <div class="p-5">
                                        <!-- A. Informasi Umum -->
                                        <div class="mb-4">
                                            <h6 class="fw-semibold mb-3">A. Informasi Umum</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Judul Penelitian <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Contoh: Skema Data Mining pada Web 5.0 yang ..." />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Tahun Pelaksanaan <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" placeholder="2025" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Ketua Pengusul <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Contoh: Dr. Dicky Noviansyah, S. Kom, M.Kom" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">NIDN/NIK Ketua Pengusul <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Contoh: 123345589" />
                                                </div>
                                            </div>

                                            <!-- Anggota -->
                                            <div class="mt-3">
                                                <label class="form-label">Anggota Penelitian</label>
                                                <table class="table table-sm table-bordered mt-2 align-middle">
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
                                                            <td>Zaimah Panjaitan, S. Kom, M. Kom</td>
                                                            <td>123345490</td>
                                                            <td>Jl. Amal No.12, Kec. Msc</td>
                                                            <td>081289823124</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Zaimah Panjaitan, S. Kom, M. Kom</td>
                                                            <td>123345490</td>
                                                            <td>Jl. Amal No.12, Kec. Msc</td>
                                                            <td>081289823124</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- B. Informasi Terkait Laporan -->
                                        <div class="mb-4">
                                            <h6 class="fw-semibold mb-3">B. Informasi Terkait Laporan</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Kata Kunci <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Contoh: Artificial Intelligence, Data Mining, Citra" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Metode Penelitian <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Contoh: Metode Penelitian Kuantitatif, Eksperimental, dll" />
                                            </div>
                                            <div>
                                                <label class="form-label">Ringkasan Laporan <span class="text-danger">*</span></label>
                                                <textarea class="form-control" rows="4" placeholder="Ketikan ringkasan laporan penelitian anda disini"></textarea>
                                                <small class="text-muted">Maksimal 300 kata</small>
                                            </div>
                                        </div>

                                        <!-- C. Upload Dokumen -->
                                        <div class="mb-4">
                                            <h6 class="fw-semibold mb-3">C. Upload Dokumen</h6>
                                            <div class="row align-items-stretch mb-4 gx-4">
                                                <label class="form-label fw-semibold">File Laporan Penelitian <span class="text-danger">*</span></label>
                                                <!-- Box Upload -->
                                                <div class="col-md-9">
                                                    <div class="h-100 border border-primary border-dashed rounded-3 p-4 text-center">
                                                        <button type="button" class="btn btn-primary px-4 rounded-pill">Upload</button>
                                                        <p class="mt-2 small text-muted">File Maks 25 MB dan berformat PDF atau DOCX.</p>
                                                    </div>
                                                </div>
                                                <!-- Unduh Panduan -->
                                                <div class="col-md-3">
                                                    <div class="h-100 border border-primary rounded-3 p-3 d-flex flex-column justify-content-center align-items-center" style="cursor: pointer;">
                                                        <i class="bi bi-file-earmark-pdf text-primary" style="font-size: 2rem;"></i>
                                                        <span class="mt-2 small">Unduh Panduan</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Lampiran Tambahan -->
                                        <div class="mb-4">
                                            <label class="form-label">Lampiran Tambahan Dijanjikan</label>
                                            <input type="file" class="form-control" multiple />
                                        </div>



                                         <h6 class="fw-semibold mb-3">
                                            <a class="text-decoration-none d-flex align-items-center"
                                                data-bs-toggle="collapse" href="#syaratKetentuan" role="button"
                                                aria-expanded="false" aria-controls="syaratKetentuan">
                                                Syarat dan Ketentuan
                                                <i class="bi bi-chevron-down ms-2"></i>
                                            </a>
                                        </h6>

                                        <!-- Konten yang bisa di-collapse -->
                                        <div class="collapse" id="syaratKetentuan">
                                            <!-- Syarat Ketua -->
                                            <h6 class="fw-semibold mb-3">Syarat Ketua Pengusul</h6>
                                            <ul class="mb-4 text-muted">
                                                <li>Dosen tetap dengan NIDN/NIDK.</li>
                                                <li>Jabatan akademik minimal Asisten Ahli.</li>
                                                <li>Pendidikan minimal S2 (Magister).</li>
                                                <li>Bidang Keilmuan relevan dengan topik yang diusulkan.</li>
                                                <li>Memiliki rekam jejak penelitian/pengabdian 3–5 tahun terakhir.</li>
                                                <li>Tidak menjadi ketua lebih dari 1 judul di tahun berjalan.</li>
                                                <li>Tidak sedang terkena sanksi pelanggaran etika akademik.</li>
                                                <li>Memiliki rencana luaran sesuai dengan skema penelitian atau pengabdian.
                                                </li>
                                                <li>Menyusun proposal sesuai format dan menyerahkan tepat waktu.</li>
                                            </ul>

                                            <!-- Syarat Anggota -->
                                            <h6 class="fw-semibold mb-3">Syarat Anggota Penelitian</h6>
                                            <ul class="text-muted">
                                                <li>Berstatus dosen (tetap/tidak tetap).</li>
                                                <li>Bidang ilmu relevan dengan topik kegiatan.</li>
                                                <li>Tidak terlibat dalam &gt;2 kegiatan sebagai anggota tahun berjalan.</li>
                                                <li>Menyatakan kesediaan aktif berkontribusi.</li>
                                                <li>Tidak sedang dikenai sanksi akademi.</li>
                                                <li>Terlibat dalam penyusunan proposal.</li>
                                                <li>(Opsional) Berasal dari luar institusi pengusul.</li>
                                            </ul>
                                        </div>


                                        <!-- Pernyataan -->
                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="checkbox" id="validasi" />
                                            <label class="form-check-label" for="validasi">
                                                Saya menyatakan bahwa informasi dan dokumen yang saya serahkan adalah benar, dan saya sanggup untuk menerima konsekuensi apabila terjadi pelanggaran. <span class="text-danger">*</span>
                                            </label>
                                        </div>

                                        <!-- Tombol -->
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-secondary">Tambah ke Draft</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>

                               
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
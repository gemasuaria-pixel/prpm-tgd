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


                                <form id="penelitianForm" class="row g-0 needs-validation" novalidate>
                                    <!-- Container Utama -->

                                    <div class=" p-5">
                                        <!-- Judul Form -->


                                        <!-- A. Informasi Umum -->
                                        <div class="mb-4">
                                            <h6 class="fw-semibold mb-3">A. Informasi Umum</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Judul penelitian <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Contoh: Edukasi Literasi Digital bagi UMKM" />
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Tahun Pelaksanaan <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" placeholder="2025" />
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Rumpun Ilmu <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Contoh: Sosial, Ekonomi" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Ketua Pengusul <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Nama lengkap Ketua" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Bidang penelitian</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Contoh: Pemberdayaan Masyarakat" />
                                                </div>
                                            </div>

                                            <!-- Anggota -->
                                            <div class="mt-3">
                                                <label class="form-label">Anggota penelitian</label>
                                                <div class="d-flex gap-2">
                                                    <input type="text" class="form-control" placeholder="Nama Anggota" />
                                                    <button type="button" class="btn btn-primary">Tambah</button>
                                                </div>
                                                <small class="text-muted">Maksimal 2 anggota</small>

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
                                            </div>
                                        </div>

                                        <!-- B. Informasi penelitian -->
                                        <div class="mb-4">
                                            <h6 class="fw-semibold mb-3">B. Informasi penelitian</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Kata Kunci <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Contoh: Literasi Digital, UMKM, Ekonomi" />
                                            </div>
                                            <div>
                                                <label class="form-label">Abstrak <span class="text-danger">*</span></label>
                                                <textarea class="form-control" rows="4" placeholder="Tuliskan abstrak penelitian maksimal 300 kata"></textarea>
                                                <small class="text-muted">Maksimal 300 kata</small>
                                            </div>
                                        </div>

                                        <!-- C. Upload Dokumen -->
                                        <div class="mb-4">

                                            <h6 class="fw-semibold mb-3">C. Upload Dokumen</h6>
                                            <div class="row align-items-stretch mb-4 gx-4">
                                                <label class="form-label fw-semibold">
                                                    File Proposal penelitian <span class="text-danger">*</span>
                                                </label>

                                                <!-- Box Upload -->
                                                <div class="col-md-9">
                                                    <div
                                                        class="h-100 border border-primary border-dashed rounded-3 p-4 text-center">
                                                        <button type="button"
                                                            class="btn btn-primary px-4 rounded-pill">Upload</button>
                                                        <p class="mt-2 small text-muted">File Maks 25 MB dan berformat PDF
                                                            atau DOCX.</p>
                                                    </div>
                                                </div>

                                                <!-- Unduh Panduan -->
                                                <div class="col-md-3">
                                                    <a href="{{}}">
                                                        <div class="h-100 border border-primary rounded-3 p-3 d-flex flex-column justify-content-center align-items-center "
                                                            onclick="downloadTemplate()" style="cursor: pointer;">
                                                            <i class="bi bi-file-earmark-pdf text-primary"
                                                                style="font-size: 2rem;"></i>
                                                            <span class="mt-2 small">Unduh Panduan</span>
                                                        </div>
                                                </div>
                                                </a>

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
                                                <li>Memiliki rekam jejak penelitian/penelitian 3–5 tahun terakhir.</li>
                                                <li>Tidak menjadi ketua lebih dari 1 judul di tahun berjalan.</li>
                                                <li>Tidak sedang terkena sanksi pelanggaran etika akademik.</li>
                                                <li>Memiliki rencana luaran sesuai dengan skema penelitian atau penelitian.
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
                                                Saya menyatakan bahwa informasi dan dokumen yang saya serahkan adalah benar.
                                                dan saya
                                                sanggup untuk menerima konsekuensi apabila terjadi pelanggaran. <span
                                                    class="text-danger">*</span>
                                            </label>
                                        </div>

                                        <!-- Tombol -->
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-secondary">Simpan sebagai
                                                Draft</button>
                                            <button type="submit" class="btn btn-primary">Kirim Usulan</button>
                                        </div>
                                    </div>
                                </form>
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

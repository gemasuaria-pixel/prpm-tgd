@extends('layouts.main')

@section('content')
<main class="app-main">
  <div class="app-content">
    <div class="container">
      <x-breadcrumbs>Upload Laporan Penelitian</x-breadcrumbs>
      <div class="row justify-content-center">
        <div class="col-xl-12">
          <div class="card shadow-sm border-0">
            <div class="card-body p-4">
              <h4 class="fw-bold">Formulir Upload Laporan Penelitian</h4>
              <p class="text-muted small mb-4">
                Formulir ini dibuat untuk memenuhi pertanyaan terkait pengunggahan laporan penelitian.
                Harap untuk melengkapi semua pertanyaan yang ada.
              </p>

              <form action="#" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- A. Informasi Umum -->
                <h6 class="fw-bold mt-4 border-bottom pb-2">A. Informasi Umum</h6>
                <div class="row g-3 mt-1">
                  <div class="col-md-6">
                    <label class="form-label">Judul Penelitian <span class="text-danger">*</span></label>
                    <input type="text" name="judul_penelitian" class="form-control"
                      placeholder="Contoh: Skema Data Mining pada Web 5.0 yang ...">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Tahun Pelaksanaan <span class="text-danger">*</span></label>
                    <input type="text" name="tahun_pelaksanaan" class="form-control" placeholder="Contoh: 2025">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Ketua Pengusul <span class="text-danger">*</span></label>
                    <input type="text" name="ketua_pengusul" class="form-control"
                      placeholder="Contoh: Dr. Dicky Noviandhisyah, S.Kom, M.Kom">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">NIDN/NIK Ketua Pengusul <span class="text-danger">*</span></label>
                    <input type="text" name="nidn_ketua" class="form-control" placeholder="Contoh: 123298338">
                  </div>
                </div>

                <!-- Daftar Anggota -->
                <div class="mt-3">
                  <table class="table table-bordered small align-middle">
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
                        <td><input type="text" class="form-control form-control-sm" name="anggota[0][nama]"
                            placeholder="Nama Anggota"></td>
                        <td><input type="text" class="form-control form-control-sm" name="anggota[0][nidn]"
                            placeholder="NIDN"></td>
                        <td><input type="text" class="form-control form-control-sm" name="anggota[0][alamat]"
                            placeholder="Alamat"></td>
                        <td><input type="text" class="form-control form-control-sm" name="anggota[0][kontak]"
                            placeholder="No. HP"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- B. Informasi Terkait Laporan -->
                <h6 class="fw-bold mt-4 border-bottom pb-2">B. Informasi Terkait Laporan</h6>

                <div class="mb-3">
                  <label class="form-label">Kata Kunci <span class="text-danger">*</span>
                    <small class="text-muted">(dipisahkan dengan koma)</small></label>
                  <input type="text" name="kata_kunci" class="form-control"
                    placeholder="Contoh: Artificial Intelligence, Data Mining, Citra">
                </div>

                <div class="mb-3">
                  <label class="form-label">Metode Penelitian <span class="text-danger">*</span></label>
                  <input type="text" name="metode_penelitian" class="form-control"
                    placeholder="Contoh: Metode Penelitian Kuantitatif, Eksperimental, dll.">
                </div>

                <div class="mb-3">
                  <label class="form-label">Ringkasan Laporan <span class="text-danger">*(Maksimal 300 kata)</span></label>
                  <textarea name="ringkasan" rows="4" class="form-control"
                    placeholder="Ketikkan ringkasan laporan penelitian anda di sini"></textarea>
                  <small class="text-muted">Tuliskan ringkasan laporan secara singkat namun komprehensif.</small>
                </div>

                <!-- C. Upload Dokumen -->
                <h6 class="fw-bold mt-4 border-bottom pb-2">C. Upload Dokumen</h6>
                <div class="row align-items-center g-3">
                  <div class="col-md-8">
                    <label class="form-label">File Laporan Penelitian <span class="text-danger">*</span></label>
                    <input type="file" name="file_laporan" class="form-control">
                    <div class="form-text">File maks. 25 MB (PDF atau DOCX)</div>
                  </div>
                  <div class="col-md-4 text-center">
                    <a href="#" class="btn btn-outline-primary w-100">
                      <i class="bi bi-file-earmark-arrow-down"></i> Unduh Panduan
                    </a>
                  </div>
                </div>

                <div class="mt-3">
                  <label class="form-label">Lampiran Tambahan Dijanjikan</label>
                  <div class="input-group">
                    <input type="text" name="lampiran_tambahan" class="form-control"
                      placeholder="Tuliskan lampiran tambahan">
                    <button class="btn btn-outline-secondary" type="button">
                      <i class="bi bi-chevron-down"></i>
                    </button>
                  </div>
                </div>

                <!-- Checkbox Pernyataan -->
                <div class="form-check mt-4 mb-3">
                  <input class="form-check-input" type="checkbox" id="pernyataan" required>
                  <label class="form-check-label small" for="pernyataan">
                    Saya menyatakan bahwa informasi dan dokumen yang saya serahkan adalah benar,
                    dan saya siap menanggung konsekuensi apabila terjadi pelanggaran.
                  </label>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end gap-2 mt-3">
                  <button type="button" class="btn btn-outline-secondary">Tambah ke Draft</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

@if (session('status'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('status') }}',
    timer: 2000,
    showConfirmButton: false
  });
</script>
@endif
@endsection

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
                Formulir ini digunakan untuk mengunggah laporan penelitian.  
                Harap isi seluruh kolom yang diwajibkan dengan benar.
              </p>

              <form action="{{ route('dosen.uploadLaporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">

                <!-- ========================================= -->
                <!-- A. INFORMASI UMUM -->
                <!-- ========================================= -->
                <h6 class="fw-bold mt-4 border-bottom pb-2">A. Informasi Umum</h6>
                <div class="row g-3 mt-1">
                  <div class="col-md-6">
                    <label class="form-label">Judul Penelitian</label>
                    <input type="text" class="form-control" value="{{ $proposal->judul ?? '' }}" readonly>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Tahun Pelaksanaan</label>
                    <input type="text" class="form-control" value="{{ $proposal->tahun_pelaksanaan ?? '' }}" readonly>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Ketua Pengusul</label>
                    <input type="text" class="form-control" value="{{ $proposal->ketua_pengusul ?? '' }}" readonly>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">NIDN/NIK Ketua Pengusul</label>
                    <input type="text" class="form-control" value="{{ $proposal->nidn_ketua ?? '' }}" readonly>
                  </div>
                </div>

                <!-- ========================================= -->
                <!-- DAFTAR ANGGOTA -->
                <!-- ========================================= -->
                <div class="mt-4">
                  <h6 class="fw-bold border-bottom pb-2">Daftar Anggota</h6>
                  <table class="table table-bordered small align-middle mt-2">
                    <thead class="table-light">
                      <tr>
                        <th>Nama</th>
                        <th>NIDN / NIM</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($proposal->members as $i => $anggota)
                      <tr>
                        <td><input type="text" class="form-control form-control-sm" value="{{ $anggota->nama }}" readonly></td>
                        <td><input type="text" class="form-control form-control-sm" value="{{ $anggota->nidn ?? $anggota->nim ?? '' }}" readonly></td>
                        <td><input type="text" class="form-control form-control-sm" value="{{ $anggota->alamat ?? '' }}" readonly></td>
                        <td><input type="text" class="form-control form-control-sm" value="{{ $anggota->kontak ?? '' }}" readonly></td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada anggota terdaftar</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>

                <!-- ========================================= -->
                <!-- B. INFORMASI LAPORAN -->
                <!-- ========================================= -->
                <h6 class="fw-bold mt-4 border-bottom pb-2">B. Informasi Terkait Laporan</h6>

                <div class="mb-3">
                  <label class="form-label">Kata Kunci <small class="text-muted">(Pisahkan dengan koma)</small></label>
                  <input type="text" name="kata_kunci" class="form-control" value="{{ old('kata_kunci') }}">
                </div>

                <div class="mb-3">
                  <label class="form-label">Metode Penelitian</label>
                  <input type="text" name="metode_penelitian" class="form-control" value="{{ old('metode_penelitian') }}">
                </div>

                <div class="mb-3">
                  <label class="form-label">Ringkasan Laporan <small class="text-danger">(Maks. 300 kata)</small></label>
                  <textarea name="ringkasan_laporan" rows="4" class="form-control" placeholder="Tuliskan ringkasan laporan di sini">{{ old('ringkasan_laporan') }}</textarea>
                </div>

                <!-- ========================================= -->
                <!-- C. UPLOAD DOKUMEN -->
                <!-- ========================================= -->
                <h6 class="fw-bold mt-4 border-bottom pb-2">C. Upload Dokumen</h6>
                <div class="mb-3">
                  <label class="form-label">File Laporan Penelitian <span class="text-danger">*</span></label>
                  <input type="file" name="file_laporan" class="form-control" required>
                  <div class="form-text">Format: PDF atau DOCX (Maks. 25 MB)</div>
                </div>

                <!-- ========================================= -->
                <!-- PERNYATAAN -->
                <!-- ========================================= -->
                <div class="form-check mt-4 mb-3">
                  <input class="form-check-input" type="checkbox" id="pernyataan" required>
                  <label class="form-check-label small" for="pernyataan">
                    Saya menyatakan bahwa informasi dan dokumen yang saya serahkan adalah benar,
                    dan siap menanggung konsekuensi apabila terjadi pelanggaran.
                  </label>
                </div>

                <!-- ========================================= -->
                <!-- AKSI -->
                <!-- ========================================= -->
                <div class="d-flex justify-content-end gap-2 mt-3">
                  <button type="reset" class="btn btn-outline-secondary">Reset</button>
                  <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

{{-- Success --}}
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

{{-- Error --}}
@if (session('error'))
<script>
  Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '{{ session('error') }}',
    timer: 3000,
    showConfirmButton: true
  });
</script>
@endif

@endsection

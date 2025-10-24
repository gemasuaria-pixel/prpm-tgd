@extends('layouts.main')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
@endpush

@section('content')
    <main class="app-main">
        <div class="app-content">
            <div class="container">
                <x-breadcrumbs>Proposal Pengabdian</x-breadcrumbs>

                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start border-bottom">
                                    <div>
                                        <h4 class="mb-1">Formulir Usulan Proposal Pengabdian</h4>
                                        <p class="small text-muted mb-0">
                                            Harap isi seluruh bagian formulir di bawah ini dengan lengkap dan benar.
                                        </p>
                                    </div>
                                </div>

                                {{-- Pesan Error Global --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        <strong>Terjadi kesalahan:</strong>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Formulir --}}
                                <form action="{{ route('dosen.pengabdian.proposal.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <!-- A. Informasi Umum -->
                                    <h6 class="fw-bold mt-4">A. Informasi Umum</h6>
                                    <div class="row g-3 mt-1">
                                        <div class="col-md-12">
                                            <label class="form-label">Judul Pengabdian <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="judul" class="form-control"
                                                value="{{ old('judul') }}"
                                                placeholder="Contoh: Penerapan Teknologi pada UKM">
                                            @error('judul')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Tahun Pelaksanaan <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="tahun_pelaksanaan" class="form-control"
                                                value="{{ old('tahun_pelaksanaan') }}" placeholder="2025">
                                            @error('tahun_pelaksanaan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Rumpun Ilmu</label>
                                            <input type="text" name="rumpun_ilmu" class="form-control"
                                                value="{{ old('rumpun_ilmu') }}" placeholder="Contoh: Manajemen">
                                            @error('rumpun')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>




                                        <div class="col-md-6">
                                            <label class="form-label">Ketua Pengusul <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" value="{{ Auth::user()->full_name }}"
                                                readonly>
                                            <input type="hidden" name="ketua_pengusul_id" value="{{ Auth::id() }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Bidang Pengabdian <span
                                                    class="text-danger">*</span></label>
                                            <select name="bidang_pengabdian" class="form-select" required>
                                                <option selected disabled>-- Pilih Bidang --</option>
                                                <option value="Teknologi Tepat Guna">Teknologi Tepat Guna</option>
                                                <option value="Pendidikan dan Literasi">Pendidikan dan Literasi</option>
                                                <option value="Kesehatan dan Lingkungan">Kesehatan dan Lingkungan</option>
                                                <option value="Ekonomi Kreatif dan Kewirausahaan">Ekonomi Kreatif dan
                                                    Kewirausahaan</option>
                                                <option value="Sosial dan Budaya">Sosial dan Budaya</option>
                                            </select>
                                            @error('bidang_pengabdian')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <!-- Pilih Anggota Dosen -->
                                        <div class="col-md-6">
                                            <label class="form-label">Pilih Anggota Dosen</label>
                                            <select id="selectAnggotaDosen" class="form-select">
                                                <option selected disabled>-- Pilih Dosen --</option>
                                                @foreach ($dosenTerdaftar as $dosen)
                                                    <option value="{{ $dosen->id }}" data-nidn="{{ $dosen->nidn }}"
                                                        data-alamat="{{ $dosen->alamat }}"
                                                        data-kontak="{{ $dosen->kontak }}">
                                                        {{ $dosen->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="text-end mt-2">
                                            <button type="button" id="tambahAnggotaDosenBtn"
                                                class="btn btn-primary btn-sm">Tambah Dosen</button>
                                        </div>

                                        <table class="table table-bordered mt-3" id="tabelAnggotaDosen">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>NIDN</th>
                                                    <th>Alamat</th>
                                                    <th>Kontak</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>

                                        <div id="hiddenAnggotaDosenInputs"></div>

                                        <!-- Anggota Mahasiswa -->
                                        <h6 class="fw-bold mt-4">Anggota (Mahasiswa)</h6>

                                        <!-- Mahasiswa 1 -->
                                        <div class="border rounded p-3 mb-3">
                                            <h6 class="fw-semibold">Mahasiswa 1</h6>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="mahasiswa[0][nama]" class="form-control"
                                                        placeholder="Nama Mahasiswa 1" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">NIM</label>
                                                    <input type="text" name="mahasiswa[0][nim]" class="form-control"
                                                        placeholder="NIM" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Program Studi</label>
                                                    <select name="mahasiswa[0][prodi]" class="form-select" required>
                                                        <option value="" selected disabled>Pilih Program Studi
                                                        </option>
                                                        <option value="Sistem Informasi">Sistem Informasi</option>
                                                        <option value="Sistem Komputer">Sistem Komputer</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Kontak</label>
                                                    <input type="text" name="mahasiswa[0][kontak]"
                                                        class="form-control" placeholder="Nomor / Email">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Alamat</label>
                                                    <input type="text" name="mahasiswa[0][alamat]"
                                                        class="form-control" placeholder="Alamat Mahasiswa 1">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Mahasiswa 2 -->
                                        <div class="border rounded p-3">
                                            <h6 class="fw-semibold">Mahasiswa 2</h6>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="mahasiswa[1][nama]" class="form-control"
                                                        placeholder="Nama Mahasiswa 2">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">NIM</label>
                                                    <input type="text" name="mahasiswa[1][nim]" class="form-control"
                                                        placeholder="NIM">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Program Studi</label>
                                                    <select name="mahasiswa[1][prodi]" class="form-select">
                                                        <option value="" selected disabled>Pilih Program Studi
                                                        </option>
                                                        <option value="Sistem Informasi">Sistem Informasi</option>
                                                        <option value="Sistem Komputer">Sistem Komputer</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Kontak</label>
                                                    <input type="text" name="mahasiswa[1][kontak]"
                                                        class="form-control" placeholder="Nomor / Email">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Alamat</label>
                                                    <input type="text" name="mahasiswa[1][alamat]"
                                                        class="form-control" placeholder="Alamat Mahasiswa 2">
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                    <!-- B. Informasi Mitra -->
                                    <h6 class="fw-bold mt-4">B. Informasi Mitra</h6>
                                    <div class="row g-3 mt-1">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Mitra <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="nama_mitra" class="form-control"
                                                value="{{ old('nama_mitra') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jenis Mitra <span
                                                    class="text-danger">*</span></label>
                                            <select name="jenis_mitra" class="form-select" required>
                                                <option value="" disabled selected>Pilih jenis mitra</option>
                                                <option value="Industri"
                                                    {{ old('jenis_mitra') == 'Industri' ? 'selected' : '' }}>Industri
                                                </option>
                                                <option value="Pemerintah"
                                                    {{ old('jenis_mitra') == 'Pemerintah' ? 'selected' : '' }}>Pemerintah
                                                </option>
                                                <option value="Komunitas"
                                                    {{ old('jenis_mitra') == 'Komunitas' ? 'selected' : '' }}>Komunitas
                                                </option>
                                                <option value="Lembaga Pendidikan"
                                                    {{ old('jenis_mitra') == 'Lembaga Pendidikan' ? 'selected' : '' }}>
                                                    Lembaga Pendidikan</option>
                                                <option value="UMKM"
                                                    {{ old('jenis_mitra') == 'UMKM' ? 'selected' : '' }}>UMKM</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Alamat Mitra <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="alamat_mitra" class="form-control"
                                                value="{{ old('alamat_mitra') }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Kontak Mitra <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="kontak_mitra" class="form-control"
                                                value="{{ old('kontak_mitra') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Pimpinan Mitra <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="pimpinan_mitra" class="form-control"
                                                value="{{ old('pimpinan_mitra') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jumlah Anggota Kelompok <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="jumlah_anggota_kelompok" class="form-control"
                                                value="{{ old('jumlah_anggota_kelompok') }}" required>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Pernyataan Kebutuhan Mitra</label>
                                            <textarea name="pernyataan_kebutuhan" class="form-control" rows="3">{{ old('pernyataan_kebutuhan') }}</textarea>
                                        </div>
                                    </div>

                                    <!-- C. Upload Dokumen -->
                                    <h6 class="fw-bold mt-4">C. Upload Dokumen</h6>
                                    <div class="mb-3">
                                        <label class="form-label">File Proposal Pengabdian <span
                                                class="text-danger">*</span></label>
                                        <input type="file" name="documents" class="form-control">
                                        <div class="form-text">File Maks 25 MB dan berformat PDF atau DOCX.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Luaran Tambahan Dijanjikan</label>
                                        <select name="luaran_tambahan_dijanjikan" class="form-select">
                                            <option selected disabled>-- Pilih --</option>
                                            <option value="Publikasi Jurnal">Publikasi Jurnal</option>
                                            <option value="Produk/Prototype">Produk/Prototype</option>
                                            <option value="Buku Ajar">Buku Ajar</option>
                                        </select>
                                    </div>

                                    <!-- Syarat & Ketentuan -->
                                    <div class="form-check mt-4 mb-3">
                                        <input class="form-check-input" type="checkbox" name="syarat_ketentuan" required>
                                        <label class="form-check-label small">
                                            Saya menyatakan bahwa informasi dan dokumen yang saya serahkan adalah benar dan
                                            siap menanggung konsekuensi jika terjadi pelanggaran.
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-outline-secondary">Simpan ke Draft</button>
                                        <button type="submit" class="btn btn-primary">Kirim Proposal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    {{-- ✅ SweetAlert Notifikasi --}}
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

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal menyimpan!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
            });
        </script>
    @endif

    <script>
        // Tom Select untuk Dosen
        new TomSelect('#selectAnggotaDosen', {
            create: false,
            maxItems: 1,
            placeholder: "Cari dan pilih dosen...",
            sortField: {
                field: "text",
                direction: "asc"
            },
            dropdownParent: 'body'
        });

        let dosenList = [];

        function renderTabelDosen() {
            const tbody = document.querySelector('#tabelAnggotaDosen tbody');
            tbody.innerHTML = '';
            const hiddenContainer = document.getElementById('hiddenAnggotaDosenInputs');
            hiddenContainer.innerHTML = '';

            dosenList.forEach((a, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${a.nama}</td>
                    <td>${a.nidn}</td>
                    <td>${a.alamat}</td>
                    <td>${a.kontak}</td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusDosen(${index})">Hapus</button></td>
                `;
                tbody.appendChild(row);
                hiddenContainer.innerHTML += `<input type="hidden" name="anggota_dosen[]" value="${a.user_id}">`;
            });
        }

        function hapusDosen(index) {
            dosenList.splice(index, 1);
            renderTabelDosen();
        }

        document.getElementById('tambahAnggotaDosenBtn').addEventListener('click', () => {
            const select = document.getElementById('selectAnggotaDosen');
            const selectedOption = select.options[select.selectedIndex];
            if (!selectedOption || selectedOption.disabled) return;

            const userId = selectedOption.value;
            const nama = selectedOption.text;
            const nidn = selectedOption.dataset.nidn;
            const alamat = selectedOption.dataset.alamat;
            const kontak = selectedOption.dataset.kontak;

            if (!dosenList.some(a => a.user_id == userId) && dosenList.length < 4) {
                dosenList.push({
                    user_id: userId,
                    nama,
                    nidn,
                    alamat,
                    kontak
                });
                renderTabelDosen();
            }

            const tomSelect = select.tomselect;
            tomSelect.clear();
        });

        renderTabelDosen();
    </script>
@endpush

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
                <x-breadcrumbs>Proposal Penelitian</x-breadcrumbs>

                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start border-bottom">
                                    <div>
                                        <h4 class="mb-1">Formulir Usulan Proposal</h4>
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
                                <form action="{{ route('dosen.penelitian.proposal.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <!-- A. Informasi Umum -->
                                    <h6 class="fw-bold mt-4">A. Informasi Umum</h6>
                                    <div class="row g-3 mt-1">



                                        <div class="col-md-6">
                                            <label class="form-label">Judul Proposal <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="judul" class="form-control"
                                                value="{{ old('judul') }}"
                                                placeholder="Contoh: Sistem Data Mining pada Web 5.0">
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
                                            <label class="form-label">Ketua Pengusul <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" value="{{ Auth::user()->full_name }}"
                                                readonly>
                                            {{-- Simpan ID user secara tersembunyi agar tidak bisa diubah dari UI --}}
                                            <input type="hidden" name="ketua_pengusul_id" value="{{ Auth::id() }}">
                                        </div>


                                        <div class="col-md-6">
                                            <label class="form-label">Rumpun Ilmu</label>
                                            <input type="text" name="rumpun_ilmu" class="form-control"
                                                value="{{ old('rumpun_ilmu') }}" placeholder="Contoh: Manajemen">
                                            @error('rumpun_ilmu')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Bidang Penelitian <span
                                                class="text-danger">*</span></label>
                                        <select name="bidang_penelitian" class="form-select">
                                            <option selected disabled>-- Pilih Bidang --</option>
                                            <option value="Teknologi Informasi"
                                                {{ old('bidang_penelitian') == 'Teknologi Informasi' ? 'selected' : '' }}>
                                                Teknologi Informasi</option>
                                            <option value="Sistem Informasi"
                                                {{ old('bidang_penelitian') == 'Sistem Informasi' ? 'selected' : '' }}>
                                                Sistem Informasi</option>
                                            <option value="Rekayasa Perangkat Lunak"
                                                {{ old('bidang_penelitian') == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>
                                                Rekayasa Perangkat Lunak</option>
                                            <option value="Kecerdasan Buatan"
                                                {{ old('bidang_penelitian') == 'Kecerdasan Buatan' ? 'selected' : '' }}>
                                                Kecerdasan Buatan</option>
                                            <option value="Jaringan Komputer"
                                                {{ old('bidang_penelitian') == 'Jaringan Komputer' ? 'selected' : '' }}>
                                                Jaringan Komputer</option>
                                        </select>
                                        @error('bidang_penelitian')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>



                                    <div class="col-md-6">
                                        <label class="form-label">Pilih Anggota Dosen</label>
                                        <select id="selectAnggota" class="form-select">
                                            <option selected disabled>-- Pilih Dosen --</option>
                                            @foreach ($dosenTerdaftar as $dosen)
                                                <option value="{{ $dosen->id }}" data-nidn="{{ $dosen->nidn }}"
                                                    data-alamat="{{ $dosen->alamat }}" data-kontak="{{ $dosen->kontak }}">
                                                    {{ $dosen->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="text-end mt-2">
                                        <button type="button" id="tambahAnggotaBtn" class="btn btn-primary btn-sm">Tambah
                                            Dosen</button>
                                    </div>

                                    <table class="table table-bordered mt-3" id="tabelAnggota">
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

                                    <div id="hiddenAnggotaInputs">
                                        @if (old('anggota'))
                                            @foreach (old('anggota') as $userId)
                                                <input type="hidden" name="anggota[]" value="{{ $userId }}">
                                            @endforeach
                                        @endif
                                    </div>








                                    <!-- B. Informasi Penelitian -->
                                    <h6 class="fw-bold mt-4">B. Informasi Penelitian</h6>

                                    <div class="mb-3">
                                        <label class="form-label">Kata Kunci</label>
                                        <input type="text" name="kata_kunci" class="form-control"
                                            value="{{ old('kata_kunci') }}"
                                            placeholder="Artificial Intelligence, Data Mining, Citra">
                                        @error('kata_kunci')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Abstrak <span class="text-danger">*(Maksimal 300
                                                kata)</span></label>
                                        <textarea name="abstrak" class="form-control" rows="4" placeholder="Ketikkan Abstrak penelitian anda di sini">{{ old('abstrak') }}</textarea>
                                        @error('abstrak')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- C. Upload Dokumen -->
                                    <h6 class="fw-bold mt-4">C. Upload Dokumen</h6>
                                    <div class="mb-3">
                                        <label class="form-label">File Proposal Penelitian <span
                                                class="text-danger">*</span></label>
                                        <input type="file" name="documents" class="form-control">
                                        <div class="form-text">File Maks 25 MB dan berformat PDF atau DOCX.</div>
                                        @error('documents')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Luaran Tambahan Dijanjikan</label>
                                        <select name="luaran_tambahan_dijanjikan" class="form-select">
                                            <option selected disabled>-- Pilih --</option>
                                            <option value="Publikasi Jurnal"
                                                {{ old('luaran_tambahan_dijanjikan') == 'Publikasi Jurnal' ? 'selected' : '' }}>
                                                Publikasi Jurnal</option>
                                            <option value="Hak Kekayaan Intelektual"
                                                {{ old('luaran_tambahan_dijanjikan') == 'Hak Kekayaan Intelektual' ? 'selected' : '' }}>
                                                Hak Kekayaan Intelektual</option>
                                            <option value="Buku Ajar"
                                                {{ old('luaran_tambahan_dijanjikan') == 'Buku Ajar' ? 'selected' : '' }}>
                                                Buku Ajar</option>
                                        </select>
                                        @error('luaran_tambahan_dijanjikan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- PERNYATAAN -->
                                    <!-- ========================================= -->
                                    <div class="form-check mt-4 mb-3">
                                        <input class="form-check-input" type="checkbox" id="syarat_ketentuan"
                                            name="syarat_ketentuan" required>
                                        <label class="form-check-label small" for="syarat_ketentuan">
                                            Saya menyatakan bahwa informasi dan dokumen yang saya serahkan adalah benar,
                                            dan siap menanggung konsekuensi apabila terjadi pelanggaran.
                                        </label>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-outline-secondary">Simpan ke Draft</button>
                                        <button type="submit" class="btn btn-primary">Kirim Proposal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border-bottom"></div>
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

@endpush
@push('scripts')
    <script>
        // Inisialisasi Tom Select
        new TomSelect('#selectAnggota', {
            create: false,
            maxItems: 1, // hanya satu dosen per tambah
            placeholder: "Cari dan pilih dosen...",
            sortField: {
                field: "text",
                direction: "asc"
            },
            dropdownParent: 'body' // menghindari dropdown ketutupan modal (kalau pakai modal)
        });

        let anggotaList = [];

        @if (old('anggota'))
            const oldAnggota = @json(old('anggota'));
            oldAnggota.forEach(id => {
                const opt = document.querySelector('#selectAnggota option[value="' + id + '"]');
                if (opt) {
                    anggotaList.push({
                        user_id: id,
                        nama: opt.text,
                        nidn: opt.dataset.nidn,
                        alamat: opt.dataset.alamat,
                        kontak: opt.dataset.kontak
                    });
                }
            });
        @endif

        function renderTable() {
            const tbody = document.querySelector('#tabelAnggota tbody');
            tbody.innerHTML = '';
            const hiddenContainer = document.getElementById('hiddenAnggotaInputs');
            hiddenContainer.innerHTML = '';

            anggotaList.forEach((a, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${a.nama}</td>
                <td>${a.nidn}</td>
                <td>${a.alamat}</td>
                <td>${a.kontak}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusAnggota(${index})">Hapus</button></td>
            `;
                tbody.appendChild(row);
                hiddenContainer.innerHTML += `<input type="hidden" name="anggota[]" value="${a.user_id}">`;
            });
        }

        function hapusAnggota(index) {
            anggotaList.splice(index, 1);
            renderTable();
        }

        document.getElementById('tambahAnggotaBtn').addEventListener('click', () => {
            const select = document.getElementById('selectAnggota');
            const selectedOption = select.options[select.selectedIndex];
            if (!selectedOption || selectedOption.disabled) return;

            const userId = selectedOption.value;
            const nama = selectedOption.text;
            const nidn = selectedOption.dataset.nidn;
            const alamat = selectedOption.dataset.alamat;
            const kontak = selectedOption.dataset.kontak;

            // Batas 4 anggota
            if (!anggotaList.some(a => a.user_id == userId) && anggotaList.length < 4) {
                anggotaList.push({
                    user_id: userId,
                    nama,
                    nidn,
                    alamat,
                    kontak
                });
                renderTable();
            }

            // reset tom select ke posisi awal
            const tomSelect = select.tomselect;
            tomSelect.clear();
        });

        // render tabel awal
        renderTable();
    </script>
@endpush

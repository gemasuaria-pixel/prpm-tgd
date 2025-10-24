@extends('layouts.main')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
@endpush

@section('content')
    <main class="app-main">
        <div class="app-content">
            <div class="container">
                <x-breadcrumbs>Upload Laporan Penelitian</x-breadcrumbs>

                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-3">Formulir Upload Laporan Penelitian</h4>

                                {{-- Pesan Error --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('dosen.penelitian.laporan.store', $proposal) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    {{-- Informasi Umum --}}
                                    <h6 class="fw-bold mt-4 border-bottom pb-2">A. Informasi Umum</h6>
                                    <div class="row g-3 mt-1">
                                        {{-- //judul laporan --}}
                                       <div class="row g-3 mt-1">
    {{-- Judul laporan (editable) --}}
    <div class="col-md-12">
        <label class="form-label fw-semibold">Judul Laporan Penelitian</label>
        <input type="text" class="form-control" name="judul" value="{{ old('judul', $proposal->judul) }}" required>
    </div>

    {{-- Informasi dari proposal (hanya tampilan) --}}
    <div class="col-md-4">
        <label class="form-label text-muted small mb-0">Tahun Pelaksanaan</label>
        <div class="fw-semibold">{{ $proposal->tahun_pelaksanaan }}</div>
    </div>

    <div class="col-md-4">
        <label class="form-label text-muted small mb-0">Rumpun Ilmu</label>
        <div class="fw-semibold">{{ $proposal->rumpun_ilmu }}</div>
    </div>

    <div class="col-md-4">
        <label class="form-label text-muted small mb-0">Bidang Ilmu</label>
        <div class="fw-semibold">{{ $proposal->bidang_penelitian }}</div>
    </div>
</div>


                                    {{-- Pilih Anggota --}}
                                    <h6 class="fw-bold mt-4 border-bottom pb-2">B. Anggota</h6>


                                    <table class="table table-bordered mt-3" id="tabelAnggota">
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
                                    <div id="hiddenAnggotaInputs"></div>

                                    {{-- Informasi Laporan --}}
                                    <h6 class="fw-bold mt-4 border-bottom pb-2">C. Informasi Laporan</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Kata Kunci</label>
                                        <input type="text" name="kata_kunci" class="form-control"
                                            placeholder="AI, Data Mining" value="{{ old('kata_kunci') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Metode Penelitian</label>
                                        <input type="text" name="metode_penelitian" class="form-control"
                                            value="{{ old('metode_penelitian') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Ringkasan Laporan</label>
                                        <textarea name="ringkasan_laporan" class="form-control" rows="4" placeholder="Ringkasan laporan">{{ old('ringkasan_laporan') }}</textarea>
                                    </div>

                                    {{-- Upload Dokumen --}}
                                    <h6 class="fw-bold mt-4 border-bottom pb-2">D. Upload Dokumen</h6>
                                    <div class="mb-3">
                                        <label class="form-label">File Laporan <span class="text-danger">*</span></label>
                                        <input type="file" name="file_laporan" class="form-control" required>
                                        <div class="form-text">Format PDF/DOCX, max 25 MB</div>
                                    </div>

                                    {{-- Luaran Penelitian --}}
                                    <h6 class="fw-bold mt-4 border-bottom pb-2">D. Luaran Penelitian</h6>

                                    <div class="mb-3">
                                        <label class="form-label">Link Jurnal</label>
                                        <div id="jurnalContainer">
                                            <input type="url" name="luaran[jurnal][]" class="form-control mb-2"
                                                placeholder="https://...">
                                        </div>

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Link Video</label>
                                        <div id="videoContainer">
                                            <input type="url" name="luaran[video][]" class="form-control mb-2"
                                                placeholder="https://...">
                                        </div>

                                    </div>

                                    {{-- Pernyataan --}}
                                    <div class="form-check mt-4 mb-3">
                                        <input class="form-check-input" type="checkbox" id="pernyataan" name="pernyataan"
                                            required>
                                        <label class="form-check-label small" for="pernyataan">
                                            Saya menyatakan bahwa informasi dan dokumen yang saya serahkan adalah benar.
                                        </label>
                                    </div>

                                    {{-- Tombol --}}
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="draft" class="btn btn-outline-secondary">draft</button>
                                        <button type="submit" class="btn btn-primary">Kirim Laporan</button>
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
    {{-- Library SweetAlert2 dan Tom Select --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    {{-- ✅ SweetAlert Notifikasi --}}
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



    <script>
        // Inisialisasi Tom Select
        new TomSelect('#selectAnggota', {
            create: false,
            maxItems: 1,
            placeholder: "Cari dan pilih dosen..."
        });

        let anggotaList = [];

        function renderTable() {
            const tbody = document.querySelector('#tabelAnggota tbody');
            const hiddenContainer = document.getElementById('hiddenAnggotaInputs');
            tbody.innerHTML = '';
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

            select.tomselect.clear();
        });

        renderTable();
    </script>
@endpush

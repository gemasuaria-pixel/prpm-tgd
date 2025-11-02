@extends('layouts.main')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
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
                            <h4 class="mb-3">Formulir Usulan Proposal Pengabdian</h4>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('dosen.pengabdian.proposal.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Judul & Tahun -->
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Judul Pengabdian *</label>
                                        <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tahun Pelaksanaan *</label>
                                        <input type="number" name="tahun_pelaksanaan" class="form-control" value="{{ old('tahun_pelaksanaan') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Rumpun Ilmu</label>
                                        <input type="text" name="rumpun_ilmu" class="form-control" value="{{ old('rumpun_ilmu') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Bidang Pengabdian *</label>
                                        <select name="bidang_pengabdian" class="form-select" required>
                                            <option disabled selected>-- Pilih Bidang --</option>
                                            <option value="Teknologi Tepat Guna">Teknologi Tepat Guna</option>
                                            <option value="Pendidikan dan Literasi">Pendidikan dan Literasi</option>
                                            <option value="Kesehatan dan Lingkungan">Kesehatan dan Lingkungan</option>
                                            <option value="Ekonomi Kreatif dan Kewirausahaan">Ekonomi Kreatif dan Kewirausahaan</option>
                                            <option value="Sosial dan Budaya">Sosial dan Budaya</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Ketua Pengusul -->
                                <div class="row g-3 mt-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Ketua Pengusul</label>
                                        <input type="text" class="form-control" value="{{ Auth::user()->full_name }}" readonly>
                                        <input type="hidden" name="ketua_pengusul_id" value="{{ Auth::id() }}">
                                    </div>
                                </div>

                                <!-- Anggota Dosen -->
                                <h6 class="mt-4">Anggota Dosen</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <select id="selectAnggotaDosen" class="form-select">
                                            <option disabled selected>-- Pilih Dosen --</option>
                                            @foreach($dosenTerdaftar as $dosen)
                                                <option value="{{ $dosen->id }}" data-nidn="{{ $dosen->nidn }}" data-alamat="{{ $dosen->alamat }}" data-kontak="{{ $dosen->kontak }}">
                                                    {{ $dosen->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" id="tambahAnggotaDosenBtn" class="btn btn-primary">Tambah Dosen</button>
                                    </div>
                                </div>

                                <table class="table mt-2" id="tabelAnggotaDosen">
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
                                <h6 class="mt-4">Anggota Mahasiswa</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <select id="selectAnggotaMhs" class="form-select" placeholder="Cari mahasiswa...">
                                            <option disabled selected>-- Pilih Mahasiswa --</option>
                                            @foreach($mahasiswaTerdaftar as $mhs)
                                                <option value="{{ $mhs->id }}" data-nim="{{ $mhs->nim }}" data-prodi="{{ $mhs->prodi }}" data-kontak="{{ $mhs->no_hp }}" data-alamat="{{ $mhs->alamat }}">
                                                    {{ $mhs->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" id="tambahAnggotaMhsBtn" class="btn btn-primary">Tambah Mahasiswa</button>
                                    </div>
                                </div>

                                <table class="table mt-2" id="tabelAnggotaMhs">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIM</th>
                                            <th>Prodi</th>
                                            <th>Kontak</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <div id="hiddenAnggotaMhsInputs"></div>

                                <!-- Mitra & Dokumen -->
                                <h6 class="mt-4">Informasi Mitra</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label>Nama Mitra *</label>
                                        <input type="text" name="nama_mitra" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Jenis Mitra *</label>
                                        <select name="jenis_mitra" class="form-select" required>
                                            <option disabled selected>Pilih Jenis</option>
                                            <option value="Industri">Industri</option>
                                            <option value="Pemerintah">Pemerintah</option>
                                            <option value="Komunitas">Komunitas</option>
                                            <option value="Lembaga Pendidikan">Lembaga Pendidikan</option>
                                            <option value="UMKM">UMKM</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Alamat Mitra *</label>
                                        <input type="text" name="alamat_mitra" class="form-control" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Kontak Mitra *</label>
                                        <input type="text" name="kontak_mitra" class="form-control" required>
                                    </div>
                                   
                                    <div class="col-md-12">
                                        <label>Pernyataan Kebutuhan</label>
                                        <textarea name="pernyataan_kebutuhan" class="form-control"></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Upload Proposal *</label>
                                        <input type="file" name="documents" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-check mt-3">
                                    <input type="checkbox" class="form-check-input" name="syarat_ketentuan" required>
                                    <label class="form-check-label">Saya menyatakan data yang saya masukkan benar.</label>
                                </div>

                                <div class="mt-3 text-end">
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
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
let dosenList = [];
let mhsList = [];

// Inisialisasi TomSelect
new TomSelect('#selectAnggotaDosen', { create:false, placeholder:"Cari Dosen..." });
new TomSelect('#selectAnggotaMhs', { create:false, placeholder:"Cari Mahasiswa..." });

// Tambah Dosen
document.getElementById('tambahAnggotaDosenBtn').addEventListener('click',()=>{
    const select = document.getElementById('selectAnggotaDosen');
    const opt = select.options[select.selectedIndex];
    if(!opt || opt.disabled) return;

    const user_id = opt.value, nama=opt.text, nidn=opt.dataset.nidn, alamat=opt.dataset.alamat, kontak=opt.dataset.kontak;
    if(!dosenList.some(a=>a.user_id==user_id)) dosenList.push({user_id,nama,nidn,alamat,kontak});
    renderTabelDosen();
    select.tomselect.clear();
});

function renderTabelDosen(){
    const tbody = document.querySelector('#tabelAnggotaDosen tbody');
    tbody.innerHTML='';
    document.getElementById('hiddenAnggotaDosenInputs').innerHTML='';
    dosenList.forEach((a,i)=>{
        const row = document.createElement('tr');
        row.innerHTML=`
            <td>${a.nama}</td>
            <td>${a.nidn}</td>
            <td>${a.alamat}</td>
            <td>${a.kontak}</td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusDosen(${i})">Hapus</button></td>
        `;
        tbody.appendChild(row);
        document.getElementById('hiddenAnggotaDosenInputs').innerHTML+=`<input type="hidden" name="anggota_dosen[]" value="${a.user_id}">`;
    });
}
function hapusDosen(i){ dosenList.splice(i,1); renderTabelDosen(); }

// Tambah Mahasiswa
document.getElementById('tambahAnggotaMhsBtn').addEventListener('click',()=>{
    const select = document.getElementById('selectAnggotaMhs');
    const opt = select.options[select.selectedIndex];
    if(!opt || opt.disabled) return;

    const mahasiswa_id = opt.value, nama=opt.text, nim=opt.dataset.nim, prodi=opt.dataset.prodi, kontak=opt.dataset.kontak, alamat=opt.dataset.alamat;
    if(!mhsList.some(a=>a.mahasiswa_id==mahasiswa_id)) mhsList.push({mahasiswa_id,nama,nim,prodi,kontak,alamat});
    renderTabelMhs();
    select.tomselect.clear();
});

function renderTabelMhs(){
    const tbody = document.querySelector('#tabelAnggotaMhs tbody');
    tbody.innerHTML='';
    document.getElementById('hiddenAnggotaMhsInputs').innerHTML='';
    mhsList.forEach((a,i)=>{
        const row = document.createElement('tr');
        row.innerHTML=`
            <td>${a.nama}</td>
            <td>${a.nim}</td>
            <td>${a.prodi}</td>
            <td>${a.kontak}</td>
            <td>${a.alamat}</td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusMhs(${i})">Hapus</button></td>
        `;
        tbody.appendChild(row);
        document.getElementById('hiddenAnggotaMhsInputs').innerHTML+=`<input type="hidden" name="mahasiswa[]" value="${a.mahasiswa_id}">`;
    });
}
function hapusMhs(i){ mhsList.splice(i,1); renderTabelMhs(); }
</script>
@endpush

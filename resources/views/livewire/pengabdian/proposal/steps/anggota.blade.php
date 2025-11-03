<!-- 🔹 Anggota Dosen -->
<h6 class="mt-4 fw-bold">Anggota Dosen</h6>
<div x-data="anggotaDosen(@entangle('anggota_dosen'))" x-init="init()">
    <div class="row g-3 align-items-end">
        <div class="col-md-8">
            <label class="form-label">Pilih Dosen</label>
            <select id="selectAnggotaDosen" class="form-select">
                <option disabled selected>-- Pilih Dosen --</option>
                @foreach($dosenTerdaftar as $dosen)
                    <option 
                        value="{{ $dosen['id']}}"
                        data-nidn="{{ $dosen['nidn']}}"
                        data-alamat="{{ $dosen['alamat'] }}"
                        data-kontak="{{ $dosen['kontak'] }}"
                    >
                        {{ $dosen['name'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-primary w-100" @click="tambahDosen()">Tambah Dosen</button>
        </div>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>NIDN</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th width="5%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(d, i) in dosenList" :key="d.id">
                    <tr>
                        <td x-text="d.nama"></td>
                        <td x-text="d.nidn"></td>
                        <td x-text="d.alamat"></td>
                        <td x-text="d.kontak"></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" @click="hapusDosen(i)">×</button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

<hr class="my-4">

<!-- 🔹 Anggota Mahasiswa -->
<h6 class="mt-4 fw-bold">Anggota Mahasiswa</h6>
<div x-data="anggotaMhs(@entangle('anggota_mahasiswa'))" x-init="init()">
    <div class="row g-3 align-items-end">
        <div class="col-md-8">
            <label class="form-label">Pilih Mahasiswa</label>
            <select id="selectAnggotaMhs" class="form-select">
                <option disabled selected>-- Pilih Mahasiswa --</option>
                @foreach($mahasiswaTerdaftar as $mhs)
                    <option 
                        value="{{ $mhs['id']}}"
                        data-nim="{{ $mhs['nim']}}" 
                        data-prodi="{{ $mhs['prodi'] }}"
                        data-kontak="{{ $mhs['no_hp'] }}"
                        data-alamat="{{ $mhs['alamat'] }}"
                    >
                        {{ $mhs['nama'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-primary w-100" @click="tambahMhs()">Tambah Mahasiswa</button>
        </div>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Prodi</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th width="5%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(m, i) in mhsList" :key="m.id">
                    <tr>
                        <td x-text="m.nama"></td>
                        <td x-text="m.nim"></td>
                        <td x-text="m.prodi"></td>
                        <td x-text="m.kontak"></td>
                        <td x-text="m.alamat"></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" @click="hapusMhs(i)">×</button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
function anggotaDosen(anggotaDosenEntangle) {
    return {
        dosenList: anggotaDosenEntangle,
      init() {
    const el = document.getElementById('selectAnggotaDosen');
    if (el.tomselect) {
        el.tomselect.destroy();
    }
    new TomSelect(el, { create: false, placeholder: "Cari dosen..." });
},

        tambahDosen() {
            const select = document.getElementById('selectAnggotaDosen');
            const opt = select.options[select.selectedIndex];
            if (!opt || opt.disabled) return;

            const data = {
                id: opt.value,
                nama: opt.text,
                nidn: opt.dataset.nidn || '-',
                alamat: opt.dataset.alamat || '-',
                kontak: opt.dataset.kontak || '-'
            };

            if (this.dosenList.some(d => d.id === data.id)) {
                alert('Dosen ini sudah ditambahkan.');
                return;
            }

            this.dosenList.push(data);
            select.tomselect.clear();
        },
        hapusDosen(i) {
            this.dosenList.splice(i, 1);
        }
    }
}

function anggotaMhs(anggotaMhsEntangle) {
    return {
        mhsList: anggotaMhsEntangle,
       init() {
    const el = document.getElementById('selectAnggotaMhs');
    if (el.tomselect) {
        el.tomselect.destroy();
    }
    new TomSelect(el, { create: false, placeholder: "Cari mahasiswa..." });
},

        tambahMhs() {
            const select = document.getElementById('selectAnggotaMhs');
            const opt = select.options[select.selectedIndex];
            if (!opt || opt.disabled) return;

            const data = {
                id: opt.value,
                nama: opt.text,
                nim: opt.dataset.nim || '-',
                prodi: opt.dataset.prodi || '-',
                kontak: opt.dataset.kontak || '-',
                alamat: opt.dataset.alamat || '-'
            };

            if (this.mhsList.some(m => m.id === data.id)) {
                alert('Mahasiswa ini sudah ditambahkan.');
                return;
            }

            this.mhsList.push(data);
            select.tomselect.clear();
        },
        hapusMhs(i) {
            this.mhsList.splice(i, 1);
        }
    }
}
</script>
@endpush

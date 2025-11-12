<!-- 🔹 Anggota Dosen -->
<h6 class="mt-4 fw-bold">Anggota Dosen</h6>

<div x-data="anggotaDosen(@entangle('anggota_dosen'), @js($dosenTerdaftar))" x-init="init()">
    <div class="row g-3 align-items-end">
        <div class="col-md-8 position-relative">
            <label class="form-label">Cari & Pilih Dosen</label>
            <input type="text" 
                class="form-control" 
                placeholder="Ketik nama dosen..." 
                x-model="search" 
                @focus="open = true" 
                @click.away="open = false">

            <!-- Dropdown hasil pencarian -->
            <ul class="list-group position-absolute w-100 mt-1 shadow-sm" 
                x-show="open && filteredDosen.length" 
                style="z-index: 1050;">
                <template x-for="dosen in filteredDosen" :key="dosen.id">
                    <li class="list-group-item list-group-item-action"
                        @click="pilihDosen(dosen)">
                        <strong x-text="dosen.name"></strong><br>
                        <small class="text-muted">NIDN: <span x-text="dosen.nidn"></span></small>
                    </li>
                </template>
            </ul>
        </div>

        <div class="col-md-4">
            <button type="button" class="btn btn-primary w-100" @click="tambahDosen()">Tambah Dosen</button>
        </div>
    </div>

    <!-- Table hasil dosen yang dipilih -->
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
                        <td x-text="d.name"></td>
                        <td x-text="d.nidn || '-'"></td>
                        <td x-text="d.alamat || '-'"></td>
                        <td x-text="d.kontak || '-'"></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger" @click="hapusDosen(i)">×</button>
                        </td>
                    </tr>
                </template>

                <tr x-show="!dosenList.length">
                    <td colspan="5" class="text-center text-muted py-3">Belum ada dosen ditambahkan.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<hr class="my-4">

<!-- 🔹 Anggota Mahasiswa -->
<h6 class="mt-4 fw-bold">Anggota Mahasiswa</h6>

<div x-data="anggotaMhs(@entangle('anggota_mahasiswa'), @js($mahasiswaTerdaftar))" x-init="init()">
    <div class="row g-3 align-items-end">
        <div class="col-md-8 position-relative">
            <label class="form-label">Cari & Pilih Mahasiswa</label>
            <input type="text" 
                class="form-control" 
                placeholder="Ketik nama mahasiswa..." 
                x-model="search" 
                @focus="open = true" 
                @click.away="open = false">

            <!-- Dropdown hasil pencarian -->
            <ul class="list-group position-absolute w-100 mt-1 shadow-sm" 
                x-show="open && filteredMhs.length" 
                style="z-index: 1050;">
                <template x-for="m in filteredMhs" :key="m.id">
                    <li class="list-group-item list-group-item-action"
                        @click="pilihMhs(m)">
                        <strong x-text="m.nama"></strong><br>
                        <small class="text-muted">NIM: <span x-text="m.nim"></span></small>
                    </li>
                </template>
            </ul>
        </div>

        <div class="col-md-4">
            <button type="button" class="btn btn-primary w-100" @click="tambahMhs()">Tambah Mahasiswa</button>
        </div>
    </div>

    <!-- Table hasil mahasiswa yang dipilih -->
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
                        <td x-text="m.no_hp"></td>
                        <td x-text="m.alamat"></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger" @click="hapusMhs(i)">×</button>
                        </td>
                    </tr>
                </template>

                <tr x-show="!mhsList.length">
                    <td colspan="6" class="text-center text-muted py-3">Belum ada mahasiswa ditambahkan.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


@push('scripts')
<script>
function anggotaDosen(anggotaDosenEntangle, dosenData) {
    return {
        dosenList: anggotaDosenEntangle,
        allDosen: dosenData,
        search: '',
        selectedDosen: null,
        open: false,

        get filteredDosen() {
            if (!this.search) return [];
            return this.allDosen.filter(d =>
                d.name.toLowerCase().includes(this.search.toLowerCase())
            ).slice(0, 8);
        },

        pilihDosen(dosen) {
            this.selectedDosen = dosen;
            this.search = dosen.name;
            this.open = false;
        },

        tambahDosen() {
            if (!this.selectedDosen) {
                alert('Pilih dosen dulu.');
                return;
            }

            if (this.dosenList.some(d => d.id === this.selectedDosen.id)) {
                alert('Dosen ini sudah ditambahkan.');
                return;
            }

            this.dosenList.push({
                id: this.selectedDosen.id,
                name: this.selectedDosen.name,
                nidn: this.selectedDosen.nidn || '-',
                alamat: this.selectedDosen.alamat || '-',
                kontak: this.selectedDosen.kontak || '-',
            });

            this.selectedDosen = null;
            this.search = '';
        },

        hapusDosen(i) {
            this.dosenList.splice(i, 1);
        },

        init() {
            // opsional, kalau mau logika tambahan di awal
        }
    };
}

function anggotaMhs(anggotaMhsEntangle, mhsData) {
    return {
        mhsList: anggotaMhsEntangle,
        allMhs: mhsData,
        search: '',
        selectedMhs: null,
        open: false,

        get filteredMhs() {
            if (!this.search) return [];
            return this.allMhs.filter(m =>
                m.nama.toLowerCase().includes(this.search.toLowerCase())
            ).slice(0, 8);
        },

        pilihMhs(m) {
            this.selectedMhs = m;
            this.search = m.nama;
            this.open = false;
        },

        tambahMhs() {
            if (!this.selectedMhs) {
                alert('Pilih mahasiswa dulu.');
                return;
            }

            if (this.mhsList.some(m => m.id === this.selectedMhs.id)) {
                alert('Mahasiswa ini sudah ditambahkan.');
                return;
            }

            this.mhsList.push({
                id: this.selectedMhs.id,
                nama: this.selectedMhs.nama,
                nim: this.selectedMhs.nim || '-',
                prodi: this.selectedMhs.prodi || '-',
                no_hp: this.selectedMhs.no_hp || '-',
                alamat: this.selectedMhs.alamat || '-',
            });

            this.selectedMhs = null;
            this.search = '';
        },

        hapusMhs(i) {
            this.mhsList.splice(i, 1);
        },

        init() {
            // opsional
        }
    };
}
</script>
@endpush

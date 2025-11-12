<!-- 🔹 Anggota Dosen -->
<h6 class="mt-4 fw-bold">Anggota Dosen</h6>

<div x-data="anggotaDosen(@entangle('anggota_dosen'))" x-init="init()">
    <div class="row g-3 align-items-end">
        <div class="col-md-8 position-relative">
            <label class="form-label">Cari & Pilih Dosen</label>
            <input type="text" class="form-control" placeholder="Ketik nama dosen..."
                   x-model="search" @focus="open = true" @click.away="open = false">

            <!-- Dropdown hasil pencarian -->
            <ul class="list-group position-absolute w-100 mt-1 shadow-sm"
                x-show="open && filteredDosen.length" style="z-index: 1000">
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
                        <td x-text="d.nidn"></td>
                        <td x-text="d.alamat"></td>
                        <td x-text="d.kontak"></td>
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

@push('scripts')
<script>
    function anggotaDosen(anggotaDosenEntangle) {
        return {
            dosenList: anggotaDosenEntangle,
            search: '',
            selectedDosen: null,
            open: false,

            // Daftar semua dosen dikirim dari Livewire sebagai JSON
            allDosen: @json($dosenTerdaftar),

            get filteredDosen() {
                if (!this.search) return [];
                return this.allDosen.filter(d =>
                    d.name.toLowerCase().includes(this.search.toLowerCase())
                ).slice(0, 8); // batasi hasil
            },

            init() {
                // Inisialisasi awal (kalau perlu)
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

                const data = {
                    id: this.selectedDosen.id,
                    name: this.selectedDosen.name,
                    nidn: this.selectedDosen.nidn || '-',
                    alamat: this.selectedDosen.alamat || '-',
                    kontak: this.selectedDosen.kontak || '-'
                };

                if (this.dosenList.some(d => d.id === data.id)) {
                    alert('Dosen ini sudah ditambahkan.');
                    return;
                }

                this.dosenList.push(data);
                this.selectedDosen = null;
                this.search = '';
            },

            hapusDosen(i) {
                this.dosenList.splice(i, 1);
            },
        }
    }
</script>
@endpush

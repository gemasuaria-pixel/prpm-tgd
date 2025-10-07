<div x-data="{ selected: @entangle('selected'), selectAll: @entangle('selectAll') }" x-cloak>
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Form tambah anggota -->
    <div class="card mt-4 border">
        <div class="card-body">
            <h6 class="fw-bold">Tambah Anggota</h6>
            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" wire:model.defer="nama" placeholder="Contoh: Dr. Ahmad Salem">
                </div>
                <div class="col-md-6">
                    <label class="form-label">NIDN (isi jika dosen)</label>
                    <input type="text" class="form-control" wire:model.defer="nidn" placeholder="123443212">
                </div>
                <div class="col-md-6">
                    <label class="form-label">NIM (isi jika mahasiswa)</label>
                    <input type="text" class="form-control" wire:model.defer="nim" placeholder="2005123456">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Alamat</label>
                    <input type="text" class="form-control" wire:model.defer="alamat" placeholder="Jl. Sukoharjo No 13">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kontak</label>
                    <input type="text" class="form-control" wire:model.defer="kontak" placeholder="08123456789">
                </div>
            </div>
            <div class="text-end mt-3">
                <button type="button" wire:click="batal" class="btn btn-secondary btn-sm">Batal</button>
                <button type="button" wire:click="addAnggota" class="btn btn-primary btn-sm">Tambah</button>
            </div>
        </div>
    </div>

    <!-- Aksi tabel -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <h6 class="fw-bold">Daftar Anggota</h6>
        <button type="button" x-bind:disabled="selected.length === 0"
            x-bind:class="selected.length === 0 ? 'btn btn-secondary btn-sm' : 'btn btn-danger btn-sm'"
            @click="$wire.hapusTerpilih()">
            <span x-text="selected.length === 0 ? 'Hapus Terpilih' : `Hapus (${selected.length})`"></span>
        </button>
    </div>

    <!-- Tabel Anggota -->
    <table class="table table-sm table-bordered mt-2 align-middle">
        <thead class="table-light">
            <tr>
                <th class="text-center" style="width:50px;">
                    <input type="checkbox" x-model="selectAll" @change="$wire.selectAll(selectAll)">
                </th>
                <th>Nama</th>
                <th>NIDN</th>
                <th>NIM</th>
                <th>Alamat</th>
                <th>Kontak</th>
            </tr>
        </thead>
        <tbody>
            @forelse($anggota as $item)
                <tr wire:key="anggota-{{ $item['id'] }}">
                    <td class="text-center">
                        <input type="checkbox" wire:model="selected" value="{{ $item['id'] }}">
                    </td>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['nidn'] }}</td>
                    <td>{{ $item['nim'] }}</td>
                    <td>{{ $item['alamat'] }}</td>
                    <td>{{ $item['kontak'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada anggota</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Hidden inputs agar data anggota ikut terkirim -->
    @foreach ($anggota as $index => $item)
        <input type="hidden" name="anggota[{{ $index }}][nama]" value="{{ $item['nama'] }}">
        <input type="hidden" name="anggota[{{ $index }}][nidn]" value="{{ $item['nidn'] }}">
        <input type="hidden" name="anggota[{{ $index }}][nim]" value="{{ $item['nim'] }}">
        <input type="hidden" name="anggota[{{ $index }}][alamat]" value="{{ $item['alamat'] }}">
        <input type="hidden" name="anggota[{{ $index }}][kontak]" value="{{ $item['kontak'] }}">
    @endforeach
    
</div>

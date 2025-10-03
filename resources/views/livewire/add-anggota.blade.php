<div x-data="anggotaComponent()" x-init="init()" x-cloak>
    <style>
        [x-cloak] { display: none !important; }
        .drag-handle { cursor: grab; }
        .sortable-ghost { opacity: 0.6; }
    </style>

    <!-- Form tambah anggota -->
    <div class="card mt-4 border">
        <div class="card-body">
            <h6 class="fw-bold">Tambah Anggota Penelitian</h6>
            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Nama Anggota</label>
                    <input type="text" class="form-control" wire:model="nama"
                        placeholder="Contoh: Dr. Ahmad Salem">
                </div>
                <div class="col-md-6">
                    <label class="form-label">NIDN Anggota</label>
                    <input type="text" class="form-control" wire:model="nidn"
                        placeholder="123443212">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Alamat Anggota</label>
                    <input type="text" class="form-control" wire:model="alamat"
                        placeholder="Jl. Sukoharjo No 13 Kec. Medan Johor">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kontak Anggota</label>
                    <input type="text" class="form-control" wire:model="kontak"
                        placeholder="08123456783">
                </div>
            </div>
            <div class="text-end mt-3">
                <button type="button" wire:click="batal"
                    class="btn btn-secondary btn-sm">Batal</button>
                <button type="button" wire:click="addAnggota"
                    class="btn btn-primary btn-sm">Tambah</button>
            </div>
        </div>
    </div>

    <!-- Aksi di atas tabel -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <h6 class="fw-bold">Daftar Anggota</h6>

        <!-- Tombol hapus: dikontrol oleh Alpine (selected entangled) -->
        <button type="button"
            id="hapus-btn"
            x-bind:disabled="selected.length === 0"
            x-bind:class="selected.length === 0 ? 'btn btn-secondary btn-sm' : 'btn btn-danger btn-sm'"
            @click="() => { if(selected.length) $wire.call('hapusTerpilih') }">
            <span x-text="selected.length === 0 ? 'Hapus Terpilih' : `Hapus (${selected.length})`"></span>
        </button>
    </div>

    <!-- Tabel Anggota (sortable) -->
    <table class="table table-sm table-bordered mt-2 align-middle">
        <thead class="table-light">
            <tr>
                <th class="text-center" style="width:50px;">
                    <input type="checkbox" wire:model="selectAll">
                </th>
                <th style="width:30px;"></th>
                <th>Nama</th>
                <th>NIDN</th>
                <th>Alamat</th>
                <th>Kontak</th>
            </tr>
        </thead>
        <tbody x-ref="tbody">
            @forelse($anggota as $item)
                <tr wire:key="anggota-{{ $item['id'] }}" data-id="{{ $item['id'] }}">
                    <td class="text-center">
                        <input type="checkbox" wire:model="selected" value="{{ $item['id'] }}">
                    </td>
                    <td class="text-center drag-handle">⠿</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['nidn'] }}</td>
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

    <!-- Alpine component & dynamic load SortableJS -->
    <script>
        function anggotaComponent() {
            return {
                // entangle Livewire props ke Alpine (dua arah)
                selected: @entangle('selected'),
                selectAll: @entangle('selectAll'),

                sortable: null,

                init() {
                    this.initSortable();

                    // re-init setelah Livewire memproses message (DOM mungkin di-replace)
                    if (window.Livewire && typeof Livewire.hook === 'function') {
                        Livewire.hook('message.processed', () => {
                            this.initSortable();
                        });
                    }
                },

                async initSortable() {
                    const tbody = this.$refs.tbody;
                    if (!tbody) return;

                    // destroy instance lama jika ada
                    if (this.sortable) {
                        try { this.sortable.destroy(); } catch(e) {}
                        this.sortable = null;
                    }

                    // load SortableJS CDN jika belum ada
                    if (typeof Sortable === 'undefined') {
                        await new Promise((resolve) => {
                            const s = document.createElement('script');
                            s.src = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js';
                            s.onload = resolve;
                            document.head.appendChild(s);
                        });
                    }

                    // init Sortable pada tbody
                    this.sortable = new Sortable(tbody, {
                        handle: '.drag-handle',
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        onEnd: (evt) => {
                            // ambil urutan id setelah drag
                            const order = Array.from(tbody.querySelectorAll('tr[data-id]')).map(tr => tr.dataset.id);
                            // kirim ke Livewire untuk disimpan
                            this.$wire.call('updateOrder', order);
                        }
                    });
                }
            }
        }
    </script>
</div>


<div class="px-3 px-lg-5 py-4">

    <style>
        /* Sentuhan kecil supaya rapi tanpa ubah tema global */
        .card-modern { border: 0; border-radius: 14px; box-shadow: 0 10px 30px rgba(17,24,39,0.06); }
        .search-input { background: #f8fafc; border: 1px solid #e6eef6; border-radius: 999px; padding-left: 3.2rem; }
        .role-pill { font-size: 0.75rem; padding: 0.25rem 0.55rem; border-radius: 999px; }
        .table-modern thead th { border-bottom: 0; color: #475569; font-weight: 600; }
        .table-modern tbody tr { background: #ffffff; }
        .muted-small { color: #6b7280; font-size: .875rem; }
        .btn-icon { width: 40px; height: 40px; padding: 0; display:inline-flex; align-items:center; justify-content:center; border-radius:10px; }
    </style>

    <div class="card card-modern overflow-hidden">
        <div class="card-body p-4 p-lg-5">
             <div class="">
                    <h4 class="mb-1 fw-bold" style="letter-spacing: -0.2px">Manage Roles</h4>
                    <div class="muted-small">Atur role untuk <span class="fw-semibold">Dosen</span> & <span class="fw-semibold">Reviewer</span></div>
                </div>
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-4 gap-3">
               

                <div class="d-flex gap-3 align-items-center w-100 w-lg-auto">
                    <div class="position-relative" style="min-width: 280px;">
                        <span class="position-absolute" style="left:14px;top:10px; color:#9ca3af;">
                            <i class="bi bi-search"></i>
                        </span>
                        <input
                            wire:model.debounce.500ms="search"
                            type="search"
                            class="form-control search-input ps-5 py-2"
                            placeholder="Cari nama atau email..."
                            aria-label="Cari pengguna">
                    </div>

                    <div class="text-end d-none d-lg-block">
                        <small class="muted-small">Menampilkan <span class="fw-semibold">{{ $users->count() }}</span> dari <span class="fw-semibold">{{ $users->total() }}</span></small>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div wire:key="user-table" class="table-responsive">
                <table class="table table-modern align-middle mb-0" style="min-width:720px">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Nama</th>
                            <th>Email</th>
                            <th>Role Sekarang</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr class="align-middle">
                            <td class="ps-3">
                                <div class="d-flex align-items-center gap-3">
                                    {{-- Avatar placeholder --}}
                                    <div style="width:44px;height:44px;border-radius:10px;background:#eef2ff;display:inline-flex;align-items:center;justify-content:center;font-weight:700;color:#3730a3">
                                        {{ strtoupper(substr($user->name,0,1)) }}
                                    </div>
                                    <div class="text-start">
                                        <div class="fw-semibold mb-0">{{ $user->name }}</div>
                                        <div class="muted-small">{{ $user->created_at?->format('d M Y') ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">
                                @forelse ($user->roles as $role)
                                    @php
                                        // peta role -> warna agar konsisten
                                        $map = [
                                            'dosen' => 'bg-info text-white',
                                            'reviewer' => 'bg-success text-white',
                                            'admin' => 'bg-dark text-white',
                                            'ketua_prpm' => 'bg-secondary text-white',
                                        ];
                                        $class = $map[$role->name] ?? 'bg-primary text-white';
                                    @endphp
                                    <span class="role-pill {{ $class }} me-1">{{ ucfirst($role->name) }}</span>
                                @empty
                                    <span class="text-muted fst-italic">Belum ada</span>
                                @endforelse
                            </td>
                            <td class="text-end pe-3">
                                <button
                                    wire:click="openModal({{ $user->id }})"
                                    class="btn btn-outline-primary btn-icon"
                                    title="Edit role {{ $user->name }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted fst-italic">Tidak ada pengguna ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="d-lg-none muted-small">Menampilkan {{ $users->count() }} dari {{ $users->total() }}</div>
                <div class="mx-auto">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
                <div class="text-end" style="min-width:120px"></div>
            </div>

        </div>
    </div>

    {{-- Modal — tetap di luar card body, tapi masih dalam satu root --}}
    <div wire:ignore.self class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form wire:submit.prevent="updateRoles" class="modal-content border-0" style="border-radius:12px;overflow:hidden;">
                <div class="modal-header bg-white border-0">
                    <div class="d-flex flex-column">
                        <h5 class="modal-title mb-0 fw-bold">Ubah Role</h5>
                        <small class="text-muted">User — <span class="text-primary">{{ $userName }}</span></small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small mb-2">Pilih role (hanya <span class="fw-semibold">Dosen</span> & <span class="fw-semibold">Reviewer</span>)</label>

                        <div class="d-flex gap-2 flex-wrap">
                            @foreach ($availableRoles as $role)
                                @php
                                    $isChecked = in_array($role, $selectedRoles ?? []);
                                @endphp
                                <div class="form-check">
                                    <input
                                        wire:model="selectedRoles"
                                        value="{{ $role }}"
                                        type="checkbox"
                                        id="r_{{ $role }}"
                                        class="form-check-input"
                                        style="width:18px;height:18px;">
                                    <label class="form-check-label ms-1" for="r_{{ $role }}">{{ ucfirst($role) }}</label>
                                </div>
                            @endforeach
                        </div>

                        @error('selectedRoles')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>

                    <button
                        type="submit"
                        class="btn btn-primary rounded-pill px-4 d-flex align-items-center gap-2"
                        wire:loading.attr="disabled"
                        wire:target="updateRoles">
                        <span wire:loading.class="d-none" wire:target="updateRoles">Simpan</span>
                        <span wire:loading wire:target="updateRoles" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal script (tetap di dalam root) --}}
    <script>
        window.addEventListener('show-role-modal', () => {
            const modal = new bootstrap.Modal(document.getElementById('roleModal'));
            modal.show();
        });

        window.addEventListener('hide-role-modal', () => {
            const inst = bootstrap.Modal.getInstance(document.getElementById('roleModal'));
            if (inst) inst.hide();
        });

        // Optional: close modal on successful update via session flash (Livewire does not auto-close on page flash)
        window.addEventListener('livewire:load', () => {
            Livewire.hook('message.processed', (message, component) => {
                // jika session success muncul (backend sudah set), hide modal
                // but we rely on 'hide-role-modal' dispatch in component — kept for safety
            });
        });
    </script>

</div>

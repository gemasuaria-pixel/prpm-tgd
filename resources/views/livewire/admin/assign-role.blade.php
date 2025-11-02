<div>
    <div class="px-3 px-lg-5 py-4">

        <style>
            .card-modern { border: 0; border-radius: 14px; box-shadow: 0 10px 30px rgba(17,24,39,0.06); }
            .search-input { background: #f8fafc; border: 1px solid #e6eef6; border-radius: 999px; padding-left: 3.2rem; }
            .role-pill { font-size: 0.75rem; padding: 0.25rem 0.55rem; border-radius: 999px; }
            .table-modern thead th { border-bottom: 0; color: #475569; font-weight: 600; }
            .table-modern tbody tr { background: #ffffff; }
            .muted-small { color: #6b7280; font-size: .875rem; }
            .btn-icon { width: 40px; height: 40px; padding: 0; display:inline-flex; align-items:center; justify-content:center; border-radius:10px; }
        </style>

        {{-- 🔍 Search --}}
        <div class="card card-modern overflow-hidden">
            <div class="card-body p-4 p-lg-5">

                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-4 gap-3">

                    <div class="d-flex gap-3 align-items-center w-100 w-lg-auto">
                        <div class="position-relative" style="min-width: 280px;">
                            <span class="position-absolute" style="left:14px;top:10px; color:#9ca3af;">
                                <i class="bi bi-search"></i>
                            </span>
                            <input
                                wire:model.live.debounce.500ms="search"
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

                {{-- 🔢 Table --}}
                <div class="table-responsive" wire:key="user-table">
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
                            <tr>
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width:44px;height:44px;border-radius:10px;background:#eef2ff;display:inline-flex;align-items:center;justify-content:center;font-weight:700;color:#3730a3">
                                            {{ strtoupper(substr($user->name,0,1)) }}
                                        </div>
                                        <div class="text-start">
                                            <div class="fw-semibold mb-0">{{ $user->name }}</div>
                                            <div class="muted-small">{{ $user->created_at?->format('d M Y') ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @forelse ($user->roles as $role)
                                        @php
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

                {{-- 🧭 Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="d-lg-none muted-small">Menampilkan {{ $users->count() }} dari {{ $users->total() }}</div>
                    <div class="mx-auto">
                        {{ $users->links(data: ['wire:navigate' => true]) }}


                    </div>
                    <div class="text-end" style="min-width:120px"></div>
                </div>

            </div>
        </div>

        {{-- ⚙️ Modal --}}
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
                            <label class="form-label small mb-2">Pilih role (hanya <strong>Dosen</strong> & <strong>Reviewer</strong>)</label>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach ($availableRoles as $role)
                                    <div class="form-check">
                                        <input
                                            wire:model.lazy="selectedRoles"
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
                            <span wire:loading.class="spinner-border spinner-border-sm" wire:target="updateRoles"  role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('style')
        @livewireStyles
    @endpush

    @push('scripts')
        @livewireScripts
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modalEl = document.getElementById('roleModal');

            modalEl.addEventListener('hide.bs.modal', () => {
                document.activeElement?.blur();
                modalEl.setAttribute('inert', '');
            });
            modalEl.addEventListener('hidden.bs.modal', () => {
                document.activeElement?.blur();
                modalEl.setAttribute('inert', '');
            });
            modalEl.addEventListener('show.bs.modal', () => {
                modalEl.removeAttribute('inert');
            });

            window.addEventListener('show-role-modal', () => {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            });

            window.addEventListener('hide-role-modal', () => {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            });
        });
        </script>
    @endpush
</div>

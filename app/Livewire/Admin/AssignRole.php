<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class AssignRole extends Component
{
    use WithPagination;

    public $search = '';
    public $availableRoles = [];
    public $selectedRoles = [];
    public $userId;
    public $userName;
    public $showModal = false;

       
    protected $queryString = ['search']; // ⬅️ hanya search yang disimpan, bukan page
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['openRoleModal' => 'openModal'];

    public function mount()
    {
        $this->availableRoles = Role::pluck('name')->toArray();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getUsersProperty()
{
    return User::with('roles')
        ->whereDoesntHave('roles', function ($q) {
            // ✅ Sembunyikan user yang punya role admin atau ketua_prpm
            $q->whereIn('name', ['admin', 'ketua_prpm']);
        })
        ->when($this->search, fn($q) =>
            $q->where(function ($sub) {
                $sub->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
        )
        ->paginate(10);
}


protected $assignableRoles = ['dosen', 'reviewer'];

public function openModal($id)
{
    $user = User::findOrFail($id);
    $this->userId = $user->id;
    $this->userName = $user->name;
    $this->selectedRoles = $user->roles->pluck('name')->toArray();

    $this->availableRoles = Role::whereIn('name', $this->assignableRoles)
                                ->pluck('name')
                                ->toArray();

    $this->dispatch('show-role-modal');
}


public function updateRoles()
{
    $this->validate([
        'selectedRoles' => 'array|min:1',
    ]);

    $user = User::findOrFail($this->userId);

    if ($user->hasAnyRole(['admin', 'ketua_prpm'])) {
        session()->flash('error', 'Role untuk user ini tidak dapat diubah.');
        return;
    }

    // 🚫 Pastikan tidak bisa memberikan role di luar whitelist
    $allowedRoles = ['dosen', 'reviewer'];
    $filteredRoles = array_intersect($this->selectedRoles, $allowedRoles);

    $user->syncRoles($filteredRoles);

    $this->dispatch('hide-role-modal');
    session()->flash('success', "Role untuk <strong>{$user->name}</strong> berhasil diperbarui!");
}




    public function render()
    {
        return view('livewire.admin.assign-role', [
            'users' => $this->users, // dari getUsersProperty()
        ]);
    }
}

<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class AssignRole extends Component
{
    use WithPagination;

    public $search = '';

    public $availableRoles = [];

    public $selectedRoles = [];

    public $userId;

    public $userName;

    protected $queryString = ['search'];

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['openRoleModal' => 'openModal'];

    protected $assignableRoles = ['dosen', 'reviewer'];

    public function mount()
    {
        $this->availableRoles = Role::whereIn('name', $this->assignableRoles)
            ->pluck('name')
            ->toArray();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getUsersProperty()
    {
        return User::with('roles')
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['admin', 'ketua_prpm']);
            })
            ->orderBy('name')
            ->paginate(10);
    }

    public function openModal($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->userName = $user->name;
        $this->selectedRoles = $user->roles->pluck('name')->toArray();

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

        $allowedRoles = $this->assignableRoles;
        $filteredRoles = array_intersect($this->selectedRoles, $allowedRoles);

        $user->syncRoles($filteredRoles);

        $this->dispatch('hide-role-modal');
        session()->flash('success', "Role untuk <strong>{$user->name}</strong> berhasil diperbarui!");
    }

    public function render()
    {
        return view('livewire.admin.assign-role', [
            'users' => $this->users,
        ]);
    }
}

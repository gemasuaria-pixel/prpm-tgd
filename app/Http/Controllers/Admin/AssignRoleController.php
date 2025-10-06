<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AssignRoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Ambil user yang punya role 'dosen' atau 'reviewer', atau belum punya role sama sekali
        $users = User::query()
            ->with('roles')
            ->where(function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['dosen', 'reviewer']);
                })->orWhereDoesntHave('roles');
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString();

        // Ambil role yang dapat dipilih
        $roles = Role::whereIn('name', ['dosen', 'reviewer'])->get();

        return view('admin.users.assign-role', compact('users', 'roles', 'search'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'string|exists:roles,name',
        ]);

        $user->syncRoles($validated['roles']);

        return redirect()->back()->with(
            'success',
            "Role pengguna <strong>{$user->name}</strong> berhasil diperbarui."
        );
    }
}

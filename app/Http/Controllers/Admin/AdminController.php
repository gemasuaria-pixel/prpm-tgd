<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    public function pendingUsers()
    {
        $pendingUsers = User::where('status', 'pending')->get();

        return view('admin.pending-users', compact('pendingUsers'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->save();

        return redirect()->back()->with('success', 'User approved!');
    }
     public function rejectUser($id)
    {
        $user = User::findOrFail($id);

        $user->status = 'rejected';   // ubah status
        $user->save();

        return back()->with('success', 'User rejected successfully.');
    }
}

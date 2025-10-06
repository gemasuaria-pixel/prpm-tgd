<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserRegistrationManagementController extends Controller
{
      public function index(){
        $pendingUsers = User::where('status', 'pending')->get();
        return view('admin.users.users-registration', compact('pendingUsers'));
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

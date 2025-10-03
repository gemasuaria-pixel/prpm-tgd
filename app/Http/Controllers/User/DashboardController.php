<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
      // Method untuk route /admin
    public function index()
    {
        // bisa return view admin dashboard
        return view('user.dashboard');
    }
}

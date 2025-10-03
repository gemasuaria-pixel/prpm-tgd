<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HomeController extends Controller
{
    

    public function dashboard(){
        return view('user.dashboard');
    }
    public function dashboardAdmin(){
        return view('admin.dashboard');
    }
    public function target(){
        return view('admin.target');
    }
    public function notification(){
        return view('admin.notification');
    }
    public function login(){
        return view('auth.login');
    }


}

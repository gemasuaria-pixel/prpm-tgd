<?php

namespace App\Http\Controllers\Pengabdian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
     public function index(){
        return view('dosen.pengabdian.index');
    }
}

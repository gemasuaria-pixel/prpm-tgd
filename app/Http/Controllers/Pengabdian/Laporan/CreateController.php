<?php

namespace App\Http\Controllers\Pengabdian\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateController extends Controller
{
       public function index(){
        return view('dosen.pengabdian.laporan.create');
    }
}

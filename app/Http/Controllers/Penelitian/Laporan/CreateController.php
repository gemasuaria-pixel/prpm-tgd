<?php

namespace App\Http\Controllers\Penelitian\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateController extends Controller
{

        public function index(){
        return view('dosen.penelitian.laporan.create');
    }
}

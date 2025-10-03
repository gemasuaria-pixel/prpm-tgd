<?php

namespace App\Http\Controllers\ResearchController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadLaporanController extends Controller
{
        public function index(){
        return view('user.penelitian.uploadLaporan');
    }
}

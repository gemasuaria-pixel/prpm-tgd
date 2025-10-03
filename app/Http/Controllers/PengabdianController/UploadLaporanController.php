<?php

namespace App\Http\Controllers\PengabdianController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadLaporanController extends Controller
{
       public function index(){
        return view('user.pengabdian.uploadLaporan');
    }
}

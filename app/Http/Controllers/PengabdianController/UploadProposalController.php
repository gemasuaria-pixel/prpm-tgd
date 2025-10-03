<?php

namespace App\Http\Controllers\PengabdianController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadProposalController extends Controller
{
     public function index(){
        return view('user.pengabdian.usulanProposal');
    }
}

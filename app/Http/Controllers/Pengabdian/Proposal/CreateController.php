<?php

namespace App\Http\Controllers\Pengabdian\Proposal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateController extends Controller
{
     public function index(){
        return view('dosen.pengabdian.proposal.create');
    }
}

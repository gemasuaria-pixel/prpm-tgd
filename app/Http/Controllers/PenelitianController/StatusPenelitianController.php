<?php

namespace App\Http\Controllers\PenelitianController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusPenelitianController extends Controller
{
    public function index(){
        return view('user.penelitian.statusPenelitian');
    }
}

<?php

namespace App\Http\Controllers\ResearchController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusPenelitianController extends Controller
{
    public function index(){
        return view('user.penelitian.statusPenelitian');
    }
}

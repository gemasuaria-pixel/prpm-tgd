<?php
namespace App\Http\Controllers\Penelitian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Proposal\Proposal;
class IndexController extends Controller
{
    public function index(){

          $user = Auth::user();

        // Ambil proposal milik dosen ini yang sudah final
        $proposalFinal = Proposal::where('dosen_id', $user->id)
            ->where('status_prpm', 'final')
            ->first();


        return view('penelitian.index',compact('proposalFinal'));
    }
}

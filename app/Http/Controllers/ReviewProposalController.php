<?php

namespace App\Http\Controllers;

use App\Models\ProposalPenelitian;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewProposalController extends Controller
{

    public function index()
    {
         // Ambil proposal yang statusnya pending
    $proposals = ProposalPenelitian::where('status_prpm', ProposalPenelitian::STATUS_PENDING)->get();

    // Ambil semua reviewer (misal role = 'dosen')
    $reviewers = User::where('role', 'dosen')->get();

    // Kirim kedua variabel ke view
    return view('review.proposal.index', compact('proposals', 'reviewers'));
    }

    public function updateStatus(Request $request, ProposalPenelitian $proposal)
    {
        $request->validate([
            'status_prpm' => 'required|in:approved,rejected,revision',
            'komentar_prpm' => 'nullable|string'
        ]);

        $proposal->update([
            'status_prpm' => $request->status_prpm,
            'komentar_prpm' => $request->komentar,
        ]);

        return redirect()->back()->with('status_prpm', 'Status Proposal berhasil diperbarui.');
    }
}
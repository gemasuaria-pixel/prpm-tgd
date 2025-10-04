<?php

namespace App\Http\Controllers;

use App\Models\UsulanPenelitian;
use Illuminate\Http\Request;

class ReviewProposalController extends Controller
{
    public function index()
    {
        $proposals = UsulanPenelitian::where('status', UsulanPenelitian::STATUS_PENDING)->get();
        return view('review.proposal.index', compact('proposals'));
    }

    public function updateStatus(Request $request, UsulanPenelitian $proposal)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,revision',
            'catatan_reviewer' => 'nullable|string'
        ]);

        $proposal->update([
            'status' => $request->status,
            'catatan_reviewer' => $request->catatan_reviewer,
        ]);

        return redirect()->back()->with('status', 'Status usulan berhasil diperbarui.');
    }
}
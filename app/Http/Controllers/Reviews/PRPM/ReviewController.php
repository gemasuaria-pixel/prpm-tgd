<?php
namespace App\Http\Controllers\Reviews\PRPM;

use App\Http\Controllers\Controller;
use App\Models\ProposalPenelitian;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $proposals = ProposalPenelitian::with(['dokumen', 'anggota'])
            ->where('status_prpm', ProposalPenelitian::STATUS_PENDING)
            ->get();

        $reviewers = User::role('dosen')->get();

        return view('reviews.prpm.index', compact('proposals', 'reviewers'));
    }

    public function updateStatus(Request $request, ProposalPenelitian $proposal)
    {
        $request->validate([
            'status_prpm' => 'required|in:approved,rejected,revision',
            'komentar_prpm' => 'nullable|string',
            'reviewer_id' => 'nullable|array',
            'reviewer_id.*' => 'exists:users,id',
        ]);

        // Update status proposal
        $proposal->update([
            'status_prpm' => $request->status_prpm,
            'komentar_prpm' => $request->komentar_prpm,
        ]);

        // Assign reviewer (polymorphic)
        if ($request->filled('reviewer_id')) {
            foreach ($request->reviewer_id as $reviewerId) {
                $proposal->reviews()->firstOrCreate(
                    ['reviewer_id' => $reviewerId],
                    ['status' => 'pending']
                );
            }
        }

        return redirect()->back()->with('success', 'Status dan reviewer berhasil diperbarui.');
    }
}

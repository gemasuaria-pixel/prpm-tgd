<?php

namespace App\Http\Controllers\Reviews\Reviewer\Penelitian;

use App\Http\Controllers\Controller;
use App\Models\Penelitian\ProposalPenelitian;
use App\Models\Review\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalReviewController extends Controller
{
    public function index()
    {
        $reviewerId = Auth::id();

        $proposals = Review::with([
            'reviewable',
            'reviewable.ketuaPengusul',
            'reviewable.anggotaDosen',
        ])
            ->where('reviewer_id', $reviewerId)
            ->where('reviewable_type', ProposalPenelitian::class)
            ->latest()
            ->paginate(10); // <-- jangan ada get()
        

        return view('reviews.reviewer.penelitian.proposal.index', compact('proposals'));
    }

    public function form(Review $review)
    {
        $review->load([
            'reviewable.documents',
            'reviewable.ketuaPengusul',
            'reviewable.anggotaDosen',
            'reviewer',
        ]);

        return view('reviews.reviewer.penelitian.proposal.form', compact('review'));
    }

    public function submit(Request $request, Review $review)
    {
        $request->validate([
            'komentar' => 'required|string',
            'status' => 'required|in:pending,approved,revision,rejected',
        ]);

        $review->update([
            'komentar' => $request->komentar,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('reviewer.review.penelitian.proposal.index')
            ->with('success', 'Review proposal berhasil disimpan.');

    }
}

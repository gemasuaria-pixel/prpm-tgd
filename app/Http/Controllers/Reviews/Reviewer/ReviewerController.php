<?php

namespace App\Http\Controllers\Reviews\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Laporan\LaporanPenelitian;
use App\Models\Proposal\Proposal;
use App\Models\Review\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewerController extends Controller
{
    public function index()
    {
        $reviews = Review::with('reviewable')
            ->where('reviewer_id', Auth::id())
            ->latest()
            ->get();

        $proposalReviews = $reviews->filter(fn ($r) => $r->reviewable_type === Proposal::class);
        $laporanReviews = $reviews->filter(fn ($r) => $r->reviewable_type === LaporanPenelitian::class);

        return view('reviews.reviewer.penelitian.index', compact('proposalReviews', 'laporanReviews'));
    }

    public function formProposal(Review $review)
    {
        return view('reviews.reviewer.penelitian.show-proposal', compact('review'));
    }

    public function formLaporan(Review $review)
    {
        $review->load([
            'reviewable.proposal.infoPenelitian',
            'reviewable.documents',
        ]);

        return view('reviews.reviewer.penelitian.show-laporan', compact('review'));
    }

    public function submit(Request $request, Review $review)
    {
        $request->validate([
            'komentar' => 'required|string',
        ]);

        $review->update([
            'komentar' => $request->komentar,
            'status' => $request->status,
        ]);

        return redirect()->route('reviewer.index')->with('success', 'Review berhasil disimpan.');
    }
}

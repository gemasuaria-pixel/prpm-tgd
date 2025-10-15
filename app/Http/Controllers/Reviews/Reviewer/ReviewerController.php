<?php

namespace App\Http\Controllers\Reviews\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Penelitian\ProposalPenelitian;
use App\Models\Penelitian\LaporanPenelitian;
use App\Models\Review\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewerController extends Controller
{
    public function index()
    {
        $reviewerId = Auth::id();

        // === Review untuk Proposal Penelitian ===
        $proposalReviews = Review::with([
            'reviewable',
            'reviewable.ketuaPengusul',
            'reviewable.anggotaDosen',
        ])
            ->where('reviewer_id', $reviewerId)
            ->where('reviewable_type', ProposalPenelitian::class)
            ->latest()
            ->get();

        // === Review untuk Laporan Penelitian ===
        $laporanReviews = Review::with([
            'reviewable',
            'reviewable.proposal',
            'reviewable.proposal.ketuaPengusul',
            'reviewable.proposal.anggotaDosen',
        ])
            ->where('reviewer_id', $reviewerId)
            ->where('reviewable_type', LaporanPenelitian::class)
            ->latest()
            ->get();

        return view('reviews.reviewer.penelitian.index', compact('proposalReviews', 'laporanReviews'));
    }

    public function formProposal(Review $review)
    {
        $review->load([
            'reviewable.documents',
            'reviewable.ketuaPengusul',
            'reviewable.anggotaDosen',
            'reviewer',
        ]);

        return view('reviews.reviewer.penelitian.show-proposal', compact('review'));
    }

    public function formLaporan(Review $review)
    {
        $review->load([
            'reviewable.proposal',
            'reviewable.proposal.ketuaPengusul',
            'reviewable.proposal.anggotaDosen',
            'reviewable.documents',
        ]);

        return view('reviews.reviewer.penelitian.show-laporan', compact('review'));
    }

    public function submit(Request $request, Review $review)
    {
        $request->validate([
            'komentar' => 'required|string',
            'status'   => 'required|in:pending,approved,revision,rejected',
        ]);

        $review->update([
            'komentar' => $request->komentar,
            'status'   => $request->status,
        ]);

        return redirect()
            ->route('reviewer.index')
            ->with('success', 'Review berhasil disimpan.');
    }
}

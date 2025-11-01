<?php

namespace App\Http\Controllers\Reviews\Reviewer\Pengabdian;

use App\Http\Controllers\Controller;
use App\Models\Pengabdian\ProposalPengabdian;
use App\Models\Review\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalReviewController extends Controller
{
    /**
     * List semua proposal pengabdian yang harus direview oleh reviewer login
     */
    public function index()
    {
        $reviewerId = Auth::id();

        $proposals = Review::with([
            'reviewable',
            'reviewable.ketuaPengusul',
            'reviewable.anggotaDosen',
            'reviewable.anggotaMahasiswa',
        ])
            ->where('reviewer_id', $reviewerId)
            ->where('reviewable_type', ProposalPengabdian::class)
            ->latest()
            ->paginate(10);

        return view('reviews.reviewer.pengabdian.proposal.index', compact('proposals'));
    }

    /**
     * Formulir review untuk 1 proposal pengabdian
     */
    public function form(Review $review)
    {
        $review->load([
            'reviewable.documents',
            'reviewable.ketuaPengusul',
            'reviewable.anggotaDosen',
            'reviewable.anggotaMahasiswa',
            'reviewer',
        ]);

        return view('reviews.reviewer.pengabdian.proposal.form', compact('review'));
    }

    /**
     * Submit hasil review pengabdian
     */
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
            ->route('reviewer.review.pengabdian.proposal.index')
            ->with('success', 'Review proposal pengabdian berhasil disimpan.');
    }
}

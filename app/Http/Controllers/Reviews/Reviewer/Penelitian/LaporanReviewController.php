<?php

namespace App\Http\Controllers\Reviews\Reviewer\Penelitian;

use App\Http\Controllers\Controller;
use App\Models\Penelitian\LaporanPenelitian;
use App\Models\Review\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanReviewController extends Controller
{
    public function index()
    {
        $reviewerId = Auth::id();

        $laporanReviews = Review::with([
            'reviewable',
            'reviewable.proposalPenelitian.ketuaPengusul',
            'reviewable.proposalPenelitian.anggotaDosen',
        ])
            ->where('reviewer_id', $reviewerId)
            ->where('reviewable_type', LaporanPenelitian::class)
            ->latest()
            ->get();

        return view('reviews.reviewer.penelitian.laporan.index', compact('laporanReviews'));
    }

    public function form(Review $review)
    {
        $review->load([
            'reviewable.proposalPenelitian',
            'reviewable.proposalPenelitian.ketuaPengusul',
            'reviewable.proposalPenelitian.anggotaDosen',
            'reviewable.documents',
        ]);

        return view('reviews.reviewer.penelitian.laporan.form', compact('review'));
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
            ->route('reviewer.laporan.index')
            ->with('success', 'Review laporan berhasil disimpan.');
    }
}

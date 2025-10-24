<?php

namespace App\Http\Controllers\Reviews\Reviewer\Pengabdian;

use App\Http\Controllers\Controller;
use App\Models\Pengabdian\LaporanPengabdian;
use App\Models\Review\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanReviewController extends Controller
{
    // Menampilkan daftar laporan pengabdian yang harus direview
    public function index()
    {
        $reviewerId = Auth::id();

        $laporanReviews = Review::with([
            'reviewable',
            'reviewable.proposalPengabdian.ketuaPengusul',
            'reviewable.proposalPengabdian.anggotaDosen',
        ])
            ->where('reviewer_id', $reviewerId)
            ->where('reviewable_type', LaporanPengabdian::class)
            ->latest()
            ->get();

        return view('reviews.reviewer.pengabdian.laporan.index', compact('laporanReviews'));
    }

    // Menampilkan form review untuk satu laporan
    public function form(Review $review)
    {
        $review->load([
            'reviewable.proposalPengabdian',
            'reviewable.proposalPengabdian.ketuaPengusul',
            'reviewable.proposalPengabdian.anggotaDosen',
            'reviewable.documents',
        ]);

        return view('reviews.reviewer.pengabdian.laporan.form', compact('review'));
    }

    // Menyimpan hasil review
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
            ->route('reviewer.review.pengabdian.laporan.index')
            ->with('success', 'Review laporan berhasil disimpan.');
    }
}

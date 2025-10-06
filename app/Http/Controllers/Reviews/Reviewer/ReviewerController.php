<?php

namespace App\Http\Controllers\Reviews\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewerController extends Controller
{

    public function index()
    {
        $reviews = Review::with('reviewable')
            ->where('reviewer_id', Auth::id())
            ->get();

        return view('reviews.reviewer.index', compact('reviews'));
    }

    public function form(Review $review)
    {
        return view('reviews.reviewer._list_penelitian', compact('review'));
    }

    public function submit(\Illuminate\Http\Request $request, Review $review)
    {
        $request->validate([
            'komentar' => 'required|string',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $review->update([
            'komentar' => $request->komentar,
            'nilai' => $request->nilai,
            'status' => 'approved',
        ]);

        return redirect()->route('reviewer.index')->with('success', 'Review berhasil disimpan.');
    }
}

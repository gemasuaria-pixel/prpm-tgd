<?php

namespace App\Http\Controllers\Reviews\Reviewer;

use Illuminate\Http\Request;
use App\Models\Review\Review;
use App\Http\Controllers\Controller;
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

    public function submit(Request $request, Review $review)
    {
        $request->validate([
            'komentar' => 'required|string',
        ]);

        $review->update([
            'komentar' => $request->komentar,
            'status' => $request->status,
        ]);
dd($review->toArray(), $request->all());

        return redirect()->route('reviewer.index')->with('success', 'Review berhasil disimpan.');
    }
}

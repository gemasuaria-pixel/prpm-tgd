<?php

namespace App\Http\Controllers\Reviews\PRPM;

use App\Http\Controllers\Controller;
use App\Models\Proposal\Proposal;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Tampilkan daftar proposal untuk direview.
     */
    public function index(Request $request)
    {
        $proposalsQuery = Proposal::with([
            'documents', 
            'members', 
            'infoPenelitian', 
            'reviews' // buat nampilin reviewer yang sudah ditugaskan
        ])->orderByDesc('created_at');

        // Filter berdasarkan status PRPM
        if ($request->filled('status')) {
            $proposalsQuery->where('status_prpm', $request->status);
        }

        // Pencarian berdasarkan judul, ketua pengusul, rumpun ilmu
        if ($request->filled('q')) {
            $q = $request->q;
            $proposalsQuery->where(function ($query) use ($q) {
                $query->where('judul', 'like', "%{$q}%")
                      ->orWhere('ketua_pengusul', 'like', "%{$q}%")
                      ->orWhere('rumpun_ilmu', 'like', "%{$q}%");
            });
        }

        // Pagination 10 per halaman
        $proposals = $proposalsQuery->paginate(10)->withQueryString();

        // Ambil semua user yang role nya dosen untuk assign reviewer
        $reviewers = User::role('reviewer')->get();

        return view('reviews.prpm.index', compact('proposals', 'reviewers'));
    }

    /**
     * Update status PRPM dan assign reviewer.
     */
    public function updateStatus(Request $request, Proposal $proposal)
    {
        $request->validate([
            'status_prpm' => 'required|in:pending,approved,rejected,revisi',
            'komentar_prpm' => 'nullable|string',
            'reviewer_id' => 'nullable|array',
            'reviewer_id.*' => 'exists:users,id',
        ]);

        // Update status & komentar
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

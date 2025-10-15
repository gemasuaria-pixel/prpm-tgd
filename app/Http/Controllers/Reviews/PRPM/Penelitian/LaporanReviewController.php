<?php

namespace App\Http\Controllers\Reviews\PRPM\Penelitian;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Penelitian\LaporanPenelitian;
use App\Models\Review\Review;

class LaporanReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = LaporanPenelitian::with([
            'proposal',
            'documents',
            'reviews.reviewer'
        ])->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('proposal', fn($q2) => 
                $q2->where('judul', 'like', "%{$q}%")
                   ->orWhereHas('ketuaPengusul', fn($q3) => $q3->where('name', 'like', "%{$q}%"))
            );
        }

        $laporans = $query->paginate(10)->withQueryString();
        $reviewers = User::role('reviewer')->get();

        return view('reviews.prpm.laporan.index', compact('laporans', 'reviewers'));
    }

    public function updateStatus(Request $request, LaporanPenelitian $laporan)
    {
        $request->validate([
            'status' => 'required|in:draft,menunggu_validasi_prpm,approved_by_prpm,revisi,rejected,final',
            'komentar_prpm' => 'nullable|string',
            'reviewer_id' => 'nullable|array',
            'reviewer_id.*' => 'exists:users,id',
        ]);

        // Update status & komentar
        $laporan->update([
            'status' => $request->status,
            'komentar_prpm' => $request->komentar_prpm
        ]);

        // Assign reviewer (jika ada)
        if ($request->filled('reviewer_id')) {
            foreach ($request->reviewer_id as $reviewerId) {
                Review::updateOrCreate(
                    [
                        'reviewable_type' => LaporanPenelitian::class,
                        'reviewable_id' => $laporan->id,
                        'reviewer_id' => $reviewerId
                    ],
                    ['status' => 'pending']
                );
            }
        }

        // Jika semua reviewer approve → final
        $allApproved = $laporan->reviews()->count() > 0 &&
                       $laporan->reviews()->where('status', 'approved')->count() === $laporan->reviews()->count();

        if ($allApproved && $request->status === 'approved_by_prpm') {
            $laporan->update(['status' => 'final']);
        }

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}

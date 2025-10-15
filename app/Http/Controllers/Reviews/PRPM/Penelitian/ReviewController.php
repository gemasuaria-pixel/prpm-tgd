<?php

namespace App\Http\Controllers\Reviews\PRPM\Penelitian;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Penelitian\ProposalPenelitian;
use App\Models\Penelitian\LaporanPenelitian;
use App\Models\Review\Review;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        // Ambil proposal penelitian beserta relasi
        $proposalsQuery = ProposalPenelitian::with([
            'documents',
            'anggotaDosen.user',
            'reviews.reviewer'
        ])->orderByDesc('created_at');

        if ($request->filled('status')) {
            $proposalsQuery->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $proposalsQuery->where(function ($query) use ($q) {
                $query->where('judul', 'like', "%{$q}%")
                      ->orWhereHas('ketuaPengusul', fn($q2) => $q2->where('name', 'like', "%{$q}%"))
                      ->orWhere('rumpun_ilmu', 'like', "%{$q}%");
            });
        }

        $proposals = $proposalsQuery->paginate(10)->withQueryString();

        // Ambil laporan penelitian
        $laporanQuery = LaporanPenelitian::with([
            'proposal',
            'documents',
            'reviews.reviewer'
        ])->orderByDesc('created_at');

        if ($request->filled('status')) {
            $laporanQuery->where('status', $request->status);
        }

        $laporans = $laporanQuery->paginate(10)->withQueryString();

        // Daftar reviewer
        $reviewers = User::role('reviewer')->get();

        return view('reviews.prpm.index', compact('proposals', 'laporans', 'reviewers'));
    }

    public function updateStatus(Request $request, ProposalPenelitian $proposal)
    {
        $request->validate([
            'status' => 'required|in:draft,menunggu_validasi_prpm,approved_by_prpm,revisi,rejected,final',
            'komentar_prpm' => 'nullable|string',
            'reviewer_id' => 'nullable|array',
            'reviewer_id.*' => 'exists:users,id',
        ]);

        // Assign reviewer
        if ($request->filled('reviewer_id')) {
            foreach ($request->reviewer_id as $reviewerId) {
                $proposal->reviews()->firstOrCreate(
                    ['reviewer_id' => $reviewerId],
                    ['status' => 'pending']
                );
            }
        }

        // Update status & komentar
        $proposal->update([
            'status' => $request->status,
            'komentar_prpm' => $request->komentar_prpm
        ]);

        // Jika semua reviewer approve → final
        $allApproved = $proposal->reviews()->count() > 0 &&
                       $proposal->reviews()->where('status', 'approved')->count() === $proposal->reviews()->count();

        if ($allApproved && $request->status === 'approved_by_prpm') {
            $proposal->update(['status' => 'final']);
        }

        return redirect()->back()->with('success', 'Status proposal berhasil diperbarui.');
    }

    public function updateStatusLaporan(Request $request, LaporanPenelitian $laporan)
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
                    ['status' => 'menunggu_validasi_prpm']
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

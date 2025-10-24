<?php

namespace App\Http\Controllers\Reviews\PRPM\Penelitian;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penelitian\LaporanPenelitian;
use Illuminate\Http\Request;

class LaporanReviewController extends Controller
{
    public function index(Request $request)
    {
        // ===============================
        // 📦 Ambil semua laporan + relasi penting
        // ===============================
        $query = LaporanPenelitian::with([
            'proposalPenelitian.ketuaPengusul',
            'documents',
            'reviews.reviewer',
        ])->orderByDesc('created_at');

        // ===============================
        // 🔎 Filter status
        // ===============================
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ===============================
        // 🔍 Pencarian
        // ===============================
        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('proposal', function ($q2) use ($q) {
                $q2->where('judul', 'like', "%{$q}%")
                    ->orWhereHas('ketuaPengusul', fn($q3) => 
                        $q3->where('name', 'like', "%{$q}%")
                    );
            });
        }

        $laporans = $query->paginate(10)->withQueryString();

        // ===============================
        // 🧠 Auto update status ke 'approved_by_reviewer' jika semua reviewer approve
        // ===============================
        foreach ($laporans as $laporan) {
            $totalReviewer = $laporan->reviews->count();
            $approvedCount = $laporan->reviews->where('status', 'approved')->count();

            if (
                $totalReviewer > 0 &&
                $approvedCount === $totalReviewer &&
                $laporan->status !== 'approved_by_reviewer' &&
                $laporan->status !== 'final'
            ) {
                $laporan->update(['status' => 'approved_by_reviewer']);
            }
        }

        $reviewers = User::role('reviewer')->get();

        return view('reviews.prpm.penelitian.laporan.index', compact('laporans', 'reviewers'));
    }

    public function form(LaporanPenelitian $laporan)
    {
        $laporan->load([
            'proposalPenelitian.ketuaPengusul',
            'documents',
            'reviews.reviewer',
        ]);

        $reviewers = User::role('reviewer')->get();

        return view('reviews.prpm.penelitian.laporan.form', compact('laporan', 'reviewers'));
    }

    public function updateStatus(Request $request, LaporanPenelitian $laporan)
    {
        $request->validate([
            'status' => 'required|in:draft,menunggu_validasi_prpm,menunggu_validasi_reviewer,approved_by_reviewer,revisi,rejected,final',
            'komentar_prpm' => 'nullable|string',
            'reviewer_id' => 'nullable|array',
            'reviewer_id.*' => 'exists:users,id',
        ]);

        // ===============================
        //  Assign reviewer (kalau ada)
        // ===============================
        if ($request->filled('reviewer_id')) {
            foreach ($request->reviewer_id as $reviewerId) {
                $laporan->reviews()->firstOrCreate(
                    ['reviewer_id' => $reviewerId],
                    ['status' => 'pending']
                );
            }
        }

        // ===============================
        //  Update status & komentar PRPM
        // ===============================
        $laporan->update([
            'status' => $request->status,
            'komentar_prpm' => $request->komentar_prpm,
        ]);

        // ===============================
        //  Cek apakah semua reviewer sudah approve
        // ===============================
        $totalReviewer = $laporan->reviews()->count();
        $approvedReviewer = $laporan->reviews()->where('status', 'approved')->count();

        if ($totalReviewer > 0 && $approvedReviewer === $totalReviewer) {
            $laporan->update(['status' => 'approved_by_reviewer']);
        }

        // ===============================
        //  Jika PRPM finalkan
        // ===============================
        if ($request->status === 'final') {
            $laporan->update(['status' => 'final']);
        }

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}

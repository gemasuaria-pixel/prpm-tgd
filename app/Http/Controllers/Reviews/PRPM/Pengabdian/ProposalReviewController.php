<?php

namespace App\Http\Controllers\Reviews\PRPM\Pengabdian;

use App\Http\Controllers\Controller;
use App\Models\Pengabdian\ProposalPengabdian;
use App\Models\User;
use Illuminate\Http\Request;

class ProposalReviewController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua proposal + relasi penting
        $query = ProposalPengabdian::with([
            'documents',
            'anggotaDosen.user',
            'anggotaMahasiswa',
            'reviews.reviewer',
            'ketuaPengusul',
        ])->orderByDesc('created_at');

        // ===============================
        //  Filter status
        // ===============================
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ===============================
        //  Search
        // ===============================
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'like', "%{$q}%")
                    ->orWhereHas('ketuaPengusul', fn($q2) => $q2->where('name', 'like', "%{$q}%"))
                    ->orWhere('rumpun_ilmu', 'like', "%{$q}%")
                    ->orWhere('nama_mitra', 'like', "%{$q}%");
            });
        }

        $proposals = $query->paginate(10)->withQueryString();

        // ===============================
        // Auto update status ke 'approved_by_reviewer' jika semua reviewer approve
        // ===============================
        foreach ($proposals as $proposal) {
            $totalReviewer = $proposal->reviews->count();
            $approvedCount = $proposal->reviews->where('status', 'approved')->count();

            if (
                $totalReviewer > 0 &&
                $approvedCount === $totalReviewer &&
                $proposal->status !== 'approved_by_reviewer' &&
                $proposal->status !== 'final'
            ) {
                $proposal->update(['status' => 'approved_by_reviewer']);
            }
        }

        // List Reviewer
        $reviewers = User::role('reviewer')->get();

        return view('reviews.prpm.pengabdian.proposal.index', compact('proposals', 'reviewers'));
    }

    public function form(ProposalPengabdian $proposal)
    {
        $proposal->load([
            'documents',
            'reviews.reviewer',
            'ketuaPengusul',
            'anggotaDosen.user',
            'anggotaMahasiswa',
        ]);

        $reviewers = User::role('reviewer')->get();

        return view('reviews.prpm.pengabdian.proposal.form', compact('proposal', 'reviewers'));
    }

    public function updateStatus(Request $request, ProposalPengabdian $proposal)
    {
        $request->validate([
            'status' => 'required|in:draft,menunggu_validasi_prpm,menunggu_validasi_reviewer,approved_by_reviewer,revisi,rejected,final',
            'komentar_prpm' => 'nullable|string',
            'reviewer_id' => 'nullable|array',
            'reviewer_id.*' => 'exists:users,id',
        ]);

        // ===============================
        // Assign reviewer (kalau ada)
        // ===============================
        if ($request->filled('reviewer_id')) {
            foreach ($request->reviewer_id as $reviewerId) {
                $proposal->reviews()->firstOrCreate(
                    ['reviewer_id' => $reviewerId],
                    ['status' => 'pending']
                );
            }
        }

        // ===============================
        //  Update status & komentar
        // ===============================
        $proposal->update([
            'status' => $request->status,
            'komentar_prpm' => $request->komentar_prpm,
        ]);

        // ===============================
        //  Cek apakah semua reviewer sudah approve
        // ===============================
        $totalReviewer = $proposal->reviews()->count();
        $approvedReviewer = $proposal->reviews()->where('status', 'approved')->count();

        if ($totalReviewer > 0 && $approvedReviewer === $totalReviewer) {
            $proposal->update(['status' => 'approved_by_reviewer']);
        }

        // ===============================
        // Jika PRPM finalkan
        // ===============================
        if ($request->status === 'final') {
            $proposal->update(['status' => 'final']);
        }

        return redirect()->back()->with('success', 'Status proposal pengabdian berhasil diperbarui.');
    }
}

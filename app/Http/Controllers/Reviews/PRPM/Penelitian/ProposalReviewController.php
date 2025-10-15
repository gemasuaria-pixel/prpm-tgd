<?php

namespace App\Http\Controllers\Reviews\PRPM\Penelitian;

use App\Http\Controllers\Controller;
use App\Models\Penelitian\ProposalPenelitian;
use App\Models\User;
use Illuminate\Http\Request;

class ProposalReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = ProposalPenelitian::with([
            'documents',
            'anggotaDosen.user',
            'reviews.reviewer',
        ])->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'like', "%{$q}%")
                    ->orWhereHas('ketuaPengusul', fn ($q2) => $q2->where('name', 'like', "%{$q}%"))
                    ->orWhere('rumpun_ilmu', 'like', "%{$q}%");
            });
        }

        $proposals = $query->paginate(10)->withQueryString();
        $reviewers = User::role('reviewer')->get();

        return view('reviews.prpm.proposal.index', compact('proposals', 'reviewers'));
    }

    public function show(ProposalPenelitian $proposal)
    {
        $proposal->load([
            'documents',
            'reviews.reviewer',
            'ketuaPengusul',
            'anggotaDosen.user',
        ])->findOrFail($proposal->id);;



        $reviewers = User::role('reviewer')->get();

        return view('reviews.prpm.proposal.show', compact('proposal', 'reviewers'));
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
            'komentar_prpm' => $request->komentar_prpm,
        ]);

        // Jika semua reviewer approve → final
        $allApproved = $proposal->reviews()->count() > 0 &&
                       $proposal->reviews()->where('status', 'approved')->count() === $proposal->reviews()->count();

        if ($allApproved && $request->status === 'approved_by_prpm') {
            $proposal->update(['status' => 'final']);
        }

        return redirect()->back()->with('success', 'Status proposal berhasil diperbarui.');
    }
}

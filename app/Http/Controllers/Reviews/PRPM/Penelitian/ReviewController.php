<?php

namespace App\Http\Controllers\Reviews\PRPM\penelitian;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Review\Review;
use App\Models\Proposal\Proposal;
use App\Http\Controllers\Controller;
use App\Models\Laporan\LaporanPenelitian;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        // 🔹 Ambil semua proposal penelitian
        $proposalsQuery = Proposal::with([
            'documents',
            'members',
            'infoPenelitian',
            'reviews.reviewer'
        ])
        ->where('jenis', 'penelitian') // hanya penelitian
        ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $proposalsQuery->where('status_prpm', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $proposalsQuery->where(function ($query) use ($q) {
                $query->where('judul', 'like', "%{$q}%")
                    ->orWhere('ketua_pengusul', 'like', "%{$q}%")
                    ->orWhere('rumpun_ilmu', 'like', "%{$q}%");
            });
        }

        $proposals = $proposalsQuery->paginate(10)->withQueryString();

        // 🔹 Ambil laporan penelitian
        $laporanQuery = LaporanPenelitian::with([
            'proposal', // relasi ke proposal
            'documents',
            'reviews.reviewer'
        ])->orderByDesc('created_at');

        if ($request->filled('status')) {
            $laporanQuery->where('status_prpm', $request->status);
        }

        $laporans = $laporanQuery->paginate(10)->withQueryString();

        // 🔹 Reviewer list
        $reviewers = User::role('reviewer')->get();

        return view('reviews.prpm.index', compact('proposals', 'laporans', 'reviewers'));
    }

    public function updateStatus(Request $request, Proposal $proposal)
    {
        $request->validate([
            'status_prpm' => 'required|in:pending,approved,rejected,revisi,final',
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

        // Update status PRPM
        $proposal->update([
            'status_prpm' => $request->status_prpm,
            'komentar_prpm' => $request->komentar_prpm,
        ]);

        // Jika semua reviewer approve → final
        $allApproved = $proposal->reviews()->count() > 0 &&
                       $proposal->reviews()->where('status', 'approved')->count() === $proposal->reviews()->count();

        if ($allApproved && $request->status_prpm === 'approved') {
            $proposal->update(['status_prpm' => 'final']);
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    public function updateStatusLaporan(Request $request, $id)
{
    $laporan = LaporanPenelitian::findOrFail($id);

    // Validasi input
    $request->validate([
        'status_prpm' => 'required|string',
        'komentar_prpm' => 'nullable|string',
        'reviewer_id' => 'nullable|array',
        'reviewer_id.*' => 'exists:users,id',
    ]);

    // Update status PRPM dan komentar
    $laporan->update([
        'status_prpm' => $request->status_prpm,
        'komentar_prpm' => $request->komentar_prpm,
    ]);
     // Jika semua reviewer approve → final
        $allApproved = $laporan->reviews()->count() > 0 &&
                       $laporan->reviews()->where('status', 'approved')->count() === $laporan->reviews()->count();

        if ($allApproved && $request->status_prpm === 'approved') {
            $laporan->update(['status_prpm' => 'final']);
        }

    // Assign reviewer (jika ada)
    if ($request->has('reviewer_id')) {
        foreach ($request->reviewer_id as $reviewerId) {
            Review::updateOrCreate(
                [
                    'reviewable_type' => LaporanPenelitian::class,
                    'reviewable_id' => $laporan->id,
                    'reviewer_id' => $reviewerId,
                ],
                [
                    'status' => 'pending',
                ]
            );
        }
    }

    return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');
}

}

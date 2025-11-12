<?php

namespace App\Livewire\Reviews\Reviewer\Pengabdian\Proposal;

use App\Models\Pengabdian\ProposalPengabdian;
use App\Models\Review\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReviewsForm extends Component
{
    public $proposalId;

    public $proposal;

    public $review;

    public $komentar;

    public $status;

    public function mount($proposalId)
    {
        $this->proposalId = $proposalId;

        // Ambil proposal + relasi penting (dokumen & anggota tetap semua, reviews hanya milik reviewer login)
        $this->proposal = ProposalPengabdian::with([
            'documents',
            'anggota.individu',
            'ketuaPengusul',
            'reviews' => fn ($q) => $q->where('reviewer_id', Auth::id())->with('reviewer'),
        ])->whereHas('reviewers', function ($q) {
            $q->where('users.id', Auth::id()); // ✨ spesifik 'users.id'
        })
            ->findOrFail($proposalId);

        // Ambil review milik reviewer yang sedang login
        $this->review = Review::where('reviewable_type', ProposalPengabdian::class)
            ->where('reviewable_id', $proposalId)
            ->where('reviewer_id', Auth::id())
            ->first();

        // Isi nilai & komentar dari review lama (jika ada)

        $this->komentar = $this->review?->komentar;
        $this->status = $this->review?->status ?? 'pending';
    }

    public function simpanReview()
    {
        // Cek apakah proposal masih bisa direview
        if ($this->proposal->status === 'final') {
            $this->dispatch('toast', type: 'error', message: 'Proposal sudah final, tidak bisa direview lagi.');

            return;
        }

        $review = Review::updateOrCreate(
            [
                'reviewable_id' => $this->proposalId,
                'reviewable_type' => ProposalPengabdian::class,
                'reviewer_id' => Auth::id(),
            ],
            [
                
                'komentar' => $this->komentar,
                'status' => $this->status,
            ]
        );

        $this->review = $review;

        $this->dispatch('toast', type: 'success', message: 'Review berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.reviews.reviewer.pengabdian.proposal.reviews-form', [
            'proposal' => $this->proposal,
            'review' => $this->review,
        ]);
    }
}

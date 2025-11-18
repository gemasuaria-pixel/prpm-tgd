<?php

namespace App\Livewire\Reviews\Reviewer\Penelitian\Proposal;

use App\Models\Penelitian\ProposalPenelitian;
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
        $this->proposal = ProposalPenelitian::with([
            'documents',
            'anggota.individu',
            'ketuaPengusul',
            'reviews' => fn ($q) => $q->where('reviewer_id', Auth::id())->with('reviewer'),
        ])->whereHas('reviewers', function ($q) {
                $q->where('users.id', Auth::id()); //  spesifik 'users.id'
            })
            ->findOrFail($proposalId);

        // Ambil review milik reviewer yang sedang login (boleh double-check)
        $this->review = $this->proposal->reviews->first();

        // Isi  komentar dari review lama (jika ada)
     
        $this->komentar = $this->review?->komentar;
        $this->status = $this->review?->status ?? 'pending';
    }

    public function simpanReview()
    {
        if ($this->proposal->status === 'final') {
            $this->dispatch('toast', type: 'error', message: 'Proposal sudah final, tidak bisa direview lagi.');

            return;
        }

        $review = Review::updateOrCreate(
            [
                'reviewable_id' => $this->proposalId,
                'reviewable_type' => ProposalPenelitian::class,
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
        return view('livewire.reviews.reviewer.penelitian.proposal.reviews-form', [
            'proposal' => $this->proposal,
            'review' => $this->review,
        ]);
    }
}

<?php

namespace App\Livewire\Reviews\Prpm\Penelitian\Proposal;

use App\Models\User;
use Livewire\Component;
use App\Models\Penelitian\ProposalPenelitian;

class ReviewsForm extends Component
{
    public $proposalId;
    public $proposal;
    public $status;
    public $reviewer_id = [];
    public $komentar_prpm;

    public function mount($proposalId)
    {
        $this->proposalId = $proposalId;
        $this->proposal = ProposalPenelitian::with([
            'documents',
            'anggota.individu',
            'reviews.reviewer',
            'ketuaPengusul',
            'anggota',
        ])->findOrFail($proposalId);

        $this->status = $this->proposal->status;
        $this->reviewer_id = $this->proposal->reviews->pluck('reviewer_id')->map(fn($id) => (int) $id)->toArray();
        $this->komentar_prpm = $this->proposal->komentar_prpm;
    }

    public function removeReviewer($index)
    {
        if (isset($this->reviewer_id[$index])) {
            $reviewerId = $this->reviewer_id[$index];

            // Hapus reviewer dari DB
            $this->proposal->reviews()->where('reviewer_id', $reviewerId)->delete();

            // Hapus dari array Livewire
            unset($this->reviewer_id[$index]);
            $this->reviewer_id = array_values($this->reviewer_id);

            // Refresh data
            $this->proposal = $this->proposal->fresh('reviews');
        }
    }

    public function updateStatus()
    {
        $proposal = ProposalPenelitian::findOrFail($this->proposalId);

        // ❌ Cegah perubahan kalau sudah final
        if ($proposal->status === 'final') {
            $this->dispatch('toast', type: 'error', message: 'Proposal sudah final, tidak bisa diubah lagi.');
            return;
        }

        // 🔄 Update status & komentar PRPM
        $proposal->update([
            'status' => $this->status,
            'komentar_prpm' => $this->komentar_prpm,
        ]);

        // 👥 Simpan reviewer baru
        if (!empty($this->reviewer_id)) {
            foreach ($this->reviewer_id as $reviewerId) {
                $proposal->reviews()->firstOrCreate(
                    [
                        'reviewer_id' => $reviewerId,
                        'reviewable_id' => $proposal->id,
                        'reviewable_type' => ProposalPenelitian::class,
                    ],
                    ['status' => 'pending']
                );
            }
        }

        // ✅ Cek apakah semua reviewer sudah approve
        $totalReviewer = $proposal->reviews()->count();
        $approvedReviewer = $proposal->reviews()->where('status', 'approved')->count();

        if ($totalReviewer > 0 && $approvedReviewer === $totalReviewer) {
            $proposal->update(['status' => 'approved_by_reviewer']);
        }

        // 🔒 Kalau admin/PRPM ubah status manual ke 'final' → validasi dulu
        if ($this->status !== 'final') {
            if ($totalReviewer > 0 && $approvedReviewer === $totalReviewer) {
                $proposal->update(['status' => 'final']);
                $this->dispatch('toast', type: 'success', message: 'Proposal telah difinalkan.');
            } 
        }

        // 🔁 Refresh data proposal
        $this->proposal = $proposal->fresh(['reviews.reviewer']);
        $this->dispatch('toast', type: 'success', message: 'Status proposal berhasil diperbarui.');
    }

    public function render()
    {
        $reviewers = User::role('reviewer')->get();
        $totalReviewer = $this->proposal->reviews->count();
        $approvedCount = $this->proposal->reviews->where('status', 'approved')->count();
        $allApproved = $totalReviewer > 0 && $approvedCount === $totalReviewer;

        return view('livewire.reviews.prpm.penelitian.proposal.reviews-form', [
            'proposal' => $this->proposal,
            'reviewers' => $reviewers,
            'allApproved' => $allApproved,
        ]);
    }
}

<?php

namespace App\Livewire\Reviews\Reviewer\Pengabdian\Proposal;

use App\Models\Pengabdian\ProposalPengabdian;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ReviewsList extends Component
{
    use WithPagination;

    public $status = '';
    public $search = '';
    public $activeTab = 'proposal';

    protected $queryString = ['status', 'search', 'activeTab'];
    protected $paginationTheme = 'bootstrap';

    public function updating($field)
    {
        if (in_array($field, ['status', 'search'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $reviewerId = Auth::id();

        $query = ProposalPengabdian::with(['ketuaPengusul', 'reviews'])
            ->whereIn('status', ['menunggu_validasi_reviewer', 'revisi', 'approved_by_reviewer'])
            // 🔹 Hanya proposal yang reviewer aktif punya review
            ->whereHas('reviews', fn($q) => $q->where('reviewer_id', $reviewerId));

        // Filter pencarian: judul atau nama ketua
        if ($this->search) {
            $q = $this->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhereHas('ketuaPengusul', fn($k) => 
                        $k->where('name', 'like', "%{$q}%")
                    );
            });
        }

        // Filter status
        if ($this->status) {
            $query->where('status', $this->status);
        }

        $proposals = $query->paginate(10);

        // Auto-update status jika semua reviewer approve
        foreach ($proposals as $proposal) {
            $totalReviewer = $proposal->reviews->count();
            $approved = $proposal->reviews->where('status', 'approved')->count();

            if ($totalReviewer > 0 && $approved === $totalReviewer && $proposal->status !== 'approved_by_reviewer') {
                $proposal->update(['status' => 'approved_by_reviewer']);
            }
        }

        return view('livewire.reviews.reviewer.pengabdian.proposal.reviews-list', [
            'proposals' => $proposals,
            'reviewers' => User::role('reviewer')->get(),
        ]);
    }

    public function updateStatus($proposalId, $status)
    {
        $proposal = ProposalPengabdian::findOrFail($proposalId);
        $proposal->update(['status' => $status]);

        // Cek approval
        $totalReviewer = $proposal->reviews()->count();
        $approvedReviewer = $proposal->reviews()->where('status', 'approved')->count();

        if ($totalReviewer > 0 && $approvedReviewer === $totalReviewer) {
            $proposal->update(['status' => 'approved_by_reviewer']);
        }

        $this->dispatch('toast', type: 'success', message: 'Status berhasil diperbarui.');
    }
}

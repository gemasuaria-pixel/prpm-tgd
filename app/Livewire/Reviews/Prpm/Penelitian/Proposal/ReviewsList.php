<?php

namespace App\Livewire\Reviews\Prpm\Penelitian\Proposal;

use App\Models\Penelitian\ProposalPenelitian;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

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
        $query = ProposalPenelitian::with(['documents', 'anggota', 'reviews.reviewer', 'ketuaPengusul'])
            ->orderByDesc('created_at');

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->search) {
            $q = $this->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhereHas('ketuaPengusul', fn ($q2) => $q2->where('name', 'like', "%{$q}%"))
                    ->orWhere('rumpun_ilmu', 'like', "%{$q}%");
            });
        }

        $proposals = $query->paginate(5);

        // Auto-update status jika semua reviewer sudah approve
        foreach ($proposals as $proposal) {
            $totalReviewer = $proposal->reviews->count();
            $approved = $proposal->reviews->where('status', 'approved')->count();

            if (
                $proposal->status !== 'final' &&
                $totalReviewer > 0 &&
                $approved === $totalReviewer &&
                $proposal->status !== 'approved_by_reviewer'
            ) {
                $proposal->update(['status' => 'approved_by_reviewer']);
            }
        }

        return view('livewire.reviews.prpm.penelitian.proposal.reviews-list', [
            'proposals' => $proposals,
            'reviewers' => User::role('reviewer')->get(),
        ]);
    }

}

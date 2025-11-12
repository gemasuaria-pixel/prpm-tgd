<?php

namespace App\Livewire\Reviews\Reviewer\Penelitian\Proposal;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Review\Review;
use App\Models\Penelitian\ProposalPenelitian;

class ReviewsList extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = ['search', 'status'];

    public function updating($field)
    {
        if (in_array($field, ['search', 'status'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $reviewerId = Auth::id();

        $query = Review::with([
            'reviewable',
            'reviewable.ketuaPengusul',
            'reviewable.anggota',
        ])
            ->where('reviewer_id', $reviewerId)
            ->where('reviewable_type', ProposalPenelitian::class)
            ->latest();

        // 🔍 Filter pencarian (judul, nama ketua, dll)
        if ($this->search) {
            $q = $this->search;
            $query->whereHas('reviewable', function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhereHas('ketuaPengusul', fn($k) => $k->where('name', 'like', "%{$q}%"));
            });
        }

        // ⚙️ Filter status review (optional)
        if ($this->status) {
            $query->where('status', $this->status);
        }

        $proposals = $query->paginate(10);

        return view('livewire.reviews.reviewer.penelitian.proposal.reviews-list', [
            'proposals' => $proposals,
        ]);
    }
}

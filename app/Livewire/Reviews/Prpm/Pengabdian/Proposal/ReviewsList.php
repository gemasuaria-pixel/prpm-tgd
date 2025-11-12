<?php

namespace App\Livewire\Reviews\Prpm\Pengabdian\Proposal;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Review\Review;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengabdian\ProposalPengabdian;

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
        $query = ProposalPengabdian::with(['documents', 'anggota', 'reviews.reviewer', 'ketuaPengusul'])
            ->orderByDesc('created_at');

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->search) {
            $q = $this->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhereHas('ketuaPengusul', fn($q2) => $q2->where('name', 'like', "%{$q}%"))
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

        return view('livewire.reviews.prpm.pengabdian.proposal.reviews-list', [
            'proposals' => $proposals,
            'reviewers' => User::role('reviewer')->get(),
        ]);
    }

}

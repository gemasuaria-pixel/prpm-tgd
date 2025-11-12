<?php

namespace App\Livewire\Reviews\Prpm\Penelitian\Laporan;

use App\Models\Penelitian\LaporanPenelitian;
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
        $query = LaporanPenelitian::with(['proposalPenelitian.ketuaPengusul'])
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

        $laporans = $query->paginate(5);

        // Auto-update status jika semua reviewer sudah approve
        foreach ($laporans as $laporan) {
            $totalReviewer = $laporan->reviews->count();
            $approved = $laporan->reviews->where('status', 'approved')->count();

            if (
                $laporan->status !== 'final' &&
                $totalReviewer > 0 &&
                $approved === $totalReviewer &&
                $laporan->status !== 'approved_by_reviewer'
            ) {
                $laporan->update(['status' => 'approved_by_reviewer']);
            }
        }

        return view('livewire.reviews.prpm.penelitian.laporan.reviews-list', [
            'laporans' => $laporans,
            'reviewers' => User::role('reviewer')->get(),
        ]);
    }


}

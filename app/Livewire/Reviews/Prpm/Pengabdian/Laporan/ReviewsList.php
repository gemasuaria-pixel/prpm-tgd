<?php

namespace App\Livewire\Reviews\Prpm\Pengabdian\Laporan;

use App\Models\Pengabdian\LaporanPengabdian;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ReviewsList extends Component
{
    use WithPagination;

    public $status = '';
    public $search = '';
    public $activeTab = 'laporan';

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
        $query = LaporanPengabdian::with(['proposalPengabdian.ketuaPengusul'])
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

        $laporans = $query->paginate(10);

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

        return view('livewire.reviews.prpm.pengabdian.laporan.reviews-list', [
            'laporans' => $laporans,
            'reviewers' => User::role('reviewer')->get(),
        ]);
    }
}

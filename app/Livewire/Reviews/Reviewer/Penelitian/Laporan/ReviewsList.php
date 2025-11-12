<?php

namespace App\Livewire\Reviews\Reviewer\Penelitian\Laporan;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Review\Review;
use App\Models\Penelitian\LaporanPenelitian;

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

        // 🔹 Ambil hanya review milik reviewer aktif
        $query = Review::with([
                'reviewable', 
                'reviewable.proposalPenelitian.ketuaPengusul'
            ])
            ->where('reviewer_id', $reviewerId)
            ->where('reviewable_type', LaporanPenelitian::class)
            ->latest();

        // 🔍 Filter pencarian: judul laporan atau nama ketua
        if ($this->search) {
            $q = $this->search;
            $query->whereHas('reviewable', function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhereHas('proposalPenelitian.ketuaPengusul', fn($k) => 
                        $k->where('name', 'like', "%{$q}%")
                    );
            });
        }

        // ⚙️ Filter status review (approved, revisi, rejected, etc.)
        if ($this->status) {
            $query->where('status', $this->status);
        }

        $laporans = $query->paginate(10);

        return view('livewire.reviews.reviewer.penelitian.laporan.reviews-list', [
            'laporans' => $laporans,
        ]);
    }
}

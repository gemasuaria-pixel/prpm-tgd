<?php

namespace App\Livewire\Reviews\Reviewer\Pengabdian\Laporan;


use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengabdian\LaporanPengabdian;

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
        $reviewerId = Auth::id();
        $query = LaporanPengabdian::with([
            'proposalPengabdian.ketuaPengusul',
            'reviews'
        ])->orderByDesc('created_at')
          // 🔹 Hanya laporan yang relevan untuk reviewer yang sedang login
          ->whereHas('reviews', fn($q) => $q->where('reviewer_id', $reviewerId));

        // Filter dropdown status
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Filter pencarian
        if ($this->search) {
            $q = $this->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhereHas('proposalPengabdian.ketuaPengusul', fn($q2) =>
                        $q2->where('name', 'like', "%{$q}%")
                    )
                    ->orWhere('bidang_fokus', 'like', "%{$q}%");
            });
        }

        $laporans = $query->paginate(5);

        // 🔹 Update status otomatis jika semua reviewer sudah approve
        foreach ($laporans as $laporan) {
            $totalReviewer = $laporan->reviews->count();
            $approved = $laporan->reviews->where('status', 'approved')->count();

            if ($totalReviewer > 0 && $approved === $totalReviewer && $laporan->status !== 'approved_by_reviewer') {
                $laporan->update(['status' => 'approved_by_reviewer']);
            }
        }

        return view('livewire.reviews.reviewer.pengabdian.laporan.reviews-list', [
            'laporans' => $laporans,
            'reviewers' => User::role('reviewer')->get(),
        ]);
    }

    public function updateStatus($laporanId, $status)
    {
        $laporan = LaporanPengabdian::findOrFail($laporanId);
        $laporan->update(['status' => $status]);

        // 🔁 Cek approval lagi
        $totalReviewer = $laporan->reviews()->count();
        $approvedReviewer = $laporan->reviews()->where('status', 'approved')->count();

        if ($totalReviewer > 0 && $approvedReviewer === $totalReviewer) {
            $laporan->update(['status' => 'approved_by_reviewer']);
        }

        $this->dispatch('toast', type: 'success', message: 'Status laporan berhasil diperbarui.');
    }
}

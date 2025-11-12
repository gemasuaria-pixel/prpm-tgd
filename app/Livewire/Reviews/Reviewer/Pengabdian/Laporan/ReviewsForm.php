<?php

namespace App\Livewire\Reviews\Reviewer\Pengabdian\Laporan;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Review\Review;
use App\Models\Pengabdian\LaporanPengabdian;

class ReviewsForm extends Component
{
    public $laporanId;
    public $laporan;
    public $myReview; // review reviewer aktif
    public $nilai;
    public $komentar;
    public $status;

    public function mount($laporanId)
    {
        $this->laporanId = $laporanId;

       
        // Ambil laporan beserta relasinya
         $this->laporan = laporanPengabdian::with([
            'documents',
           
            'proposalPengabdian.ketuaPengusul',
            'reviews' => fn ($q) => $q->where('reviewer_id', Auth::id())->with('reviewer'),
        ])->whereHas('reviewers', function ($q) {
                $q->where('users.id', Auth::id()); // ✨ spesifik 'users.id'
            })
            ->findOrFail($laporanId);


        // Ambil review milik reviewer yang sedang login
        $this->myReview = $this->laporan->reviews
            ->where('reviewer_id', Auth::id())
            ->first();

        // Isi form jika sudah pernah review
        $this->nilai = $this->myReview?->nilai;
        $this->komentar = $this->myReview?->komentar;
        $this->status = $this->myReview?->status ?? 'pending';
    }

    public function simpanReview()
    {
        // Cegah review jika laporan sudah final
        if ($this->laporan->status === 'final') {
            $this->dispatch('toast', type: 'error', message: 'Laporan sudah final, tidak bisa direview lagi.');
            return;
        }

        // Simpan atau perbarui review milik reviewer aktif
        $review = Review::updateOrCreate(
            [
                'reviewable_id' => $this->laporanId,
                'reviewable_type' => LaporanPengabdian::class,
                'reviewer_id' => Auth::id(),
            ],
            [
                'nilai' => $this->nilai,
                'komentar' => $this->komentar,
                'status' => $this->status,
            ]
        );

        $this->myReview = $review;

        // Periksa apakah semua reviewer sudah approve
        $totalReviewer = $this->laporan->reviews->count();
        $approvedReviewer = $this->laporan->reviews->where('status', 'approved')->count();

        if ($totalReviewer > 0 && $approvedReviewer === $totalReviewer) {
            $this->laporan->update(['status' => 'approved_by_reviewer']);
        }

        $this->laporan->refresh();

        $this->dispatch('toast', type: 'success', message: 'Review laporan berhasil disimpan.');
    }

    public function render()
    {
        // Hanya passing review reviewer aktif ke Blade
        return view('livewire.reviews.reviewer.pengabdian.laporan.reviews-form', [
            'laporan' => $this->laporan,
            'myReview' => $this->myReview,
            'allApproved' => $this->laporan->reviews->count() > 0 &&
                             $this->laporan->reviews->where('status', 'approved')->count() === $this->laporan->reviews->count(),
        ]);
    }
}

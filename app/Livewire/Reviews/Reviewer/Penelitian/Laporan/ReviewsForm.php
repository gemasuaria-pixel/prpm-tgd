<?php

namespace App\Livewire\Reviews\Reviewer\Penelitian\Laporan;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Review\Review;
use App\Models\Penelitian\LaporanPenelitian;

class ReviewsForm extends Component
{
    public $laporanId;
    public $laporan;
    public $review;
    public $komentar;
    public $status;

    public function mount($laporanId)
    {
        $this->laporanId = $laporanId;

        // Ambil laporan beserta relasinya
         $this->laporan = laporanPenelitian::with([
            'documents',
            'proposalPenelitian.ketuaPengusul',
            'reviews' => fn ($q) => $q->where('reviewer_id', Auth::id())->with('reviewer'),
        ])->whereHas('reviewers', function ($q) {
                $q->where('users.id', Auth::id()); // ✨ spesifik 'users.id'
            })->findOrFail($laporanId);

        // Ambil review milik reviewer yang sedang login
        $this->review = Review::where('reviewable_type', LaporanPenelitian::class)
            ->where('reviewable_id', $laporanId)
            ->where('reviewer_id', Auth::id())
            ->first();

        // Isi form jika sudah pernah review
        $this->komentar = $this->review?->komentar;
        $this->status = $this->review?->status ?? 'pending';
    }

    public function simpanReview()
    {
        // Cegah review jika laporan sudah final
        if ($this->laporan->status === 'final') {
            $this->dispatch('toast', type: 'error', message: 'Laporan sudah final, tidak bisa direview lagi.');
            return;
        }

        // Simpan atau perbarui review
        $review = Review::updateOrCreate(
            [
                'reviewable_id' => $this->laporanId,
                'reviewable_type' => LaporanPenelitian::class,
                'reviewer_id' => Auth::id(),
            ],
            [
                'komentar' => $this->komentar,
                'status' => $this->status,
            ]
        );

        $this->review = $review;

        $this->dispatch('toast', type: 'success', message: 'Review laporan berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.reviews.reviewer.penelitian.laporan.reviews-form', [
            'laporan' => $this->laporan,
            'review' => $this->review,
        ]);
    }
}

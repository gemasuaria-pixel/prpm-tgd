<?php

namespace App\Livewire\Reviews\Prpm\Pengabdian\Laporan;

use App\Models\User;
use Livewire\Component;
use App\Models\Pengabdian\LaporanPengabdian;

class ReviewsForm extends Component
{
    public $laporanId;
    public $laporan;
    public $status;
    public $reviewer_id = [];
    public $komentar_prpm;

    public function mount($laporanId)
    {
        $this->laporanId = $laporanId;

        $this->laporan = LaporanPengabdian::with([
            'documents',
            'proposalPengabdian.ketuaPengusul',
            'reviews.reviewer',
        ])->findOrFail($laporanId);

        $this->status = $this->laporan->status;
        $this->reviewer_id = $this->laporan->reviews->pluck('reviewer_id')->map(fn($id) => (int) $id)->toArray();
        $this->komentar_prpm = $this->laporan->komentar_prpm;
    }

    public function removeReviewer($index)
    {
        if (!isset($this->reviewer_id[$index])) return;

        $reviewerId = $this->reviewer_id[$index];

        $this->laporan->reviews()->where('reviewer_id', $reviewerId)->delete();

        unset($this->reviewer_id[$index]);
        $this->reviewer_id = array_values($this->reviewer_id);

        $this->laporan = $this->laporan->fresh('reviews');
    }

    public function updateStatus()
    {
        $laporan = LaporanPengabdian::findOrFail($this->laporanId);

        // 🔒 Cegah perubahan jika status sudah final
        if ($laporan->status === 'final') {
            $this->dispatch('toast', type: 'error', message: 'Laporan sudah final, tidak bisa diubah.');
            return;
        }

        // 📝 Update status & komentar PRPM
        $laporan->update([
            'status' => $this->status,
            'komentar_prpm' => $this->komentar_prpm,
        ]);

        // 🧹 Sinkronisasi reviewer
        $laporan->reviews()->whereNotIn('reviewer_id', $this->reviewer_id)->delete();

        foreach ($this->reviewer_id as $reviewerId) {
            $laporan->reviews()->firstOrCreate(
                [
                    'reviewer_id' => $reviewerId,
                    'reviewable_id' => $laporan->id,
                    'reviewable_type' => LaporanPengabdian::class,
                ],
                ['status' => 'pending']
            );
        }

        // ✅ Otomatis ubah ke approved_by_reviewer jika semua reviewer setuju
        $totalReviewer = $laporan->reviews()->count();
        $approvedReviewer = $laporan->reviews()->where('status', 'approved')->count();

        if ($totalReviewer > 0 && $approvedReviewer === $totalReviewer) {
            $laporan->update(['status' => 'approved_by_reviewer']);
        }

        // 🔒 Kalau admin/PRPM ubah status manual ke 'final' → validasi dulu
        if ($this->status !== 'final') {
            if ($totalReviewer > 0 && $approvedReviewer === $totalReviewer) {
                $laporan->update(['status' => 'final']);
                $this->dispatch('toast', type: 'success', message: 'Proposal telah difinalkan.');
            } 
        }

        // 🚀 Jika PRPM menandai sebagai final
        if ($this->status === 'final') {
            $laporan->update(['status' => 'final']);
        }

        $this->laporan = $laporan->fresh(['reviews.reviewer']);
        $this->dispatch('toast', type: 'success', message: 'Status laporan berhasil diperbarui.');
    }

    public function render()
    {
        $reviewers = User::role('reviewer')->get();
        $reviews = $this->laporan->reviews;

        $totalReviewer = $reviews->count();
        $approvedCount = $reviews->where('status', 'approved')->count();
        $allApproved = $totalReviewer > 0 && $approvedCount === $totalReviewer;

        return view('livewire.reviews.prpm.pengabdian.laporan.reviews-form', [
            'laporan' => $this->laporan,
            'reviewers' => $reviewers,
            'allApproved' => $allApproved,
        ]);
    }
}

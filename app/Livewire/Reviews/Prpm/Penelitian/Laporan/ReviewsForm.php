<?php

namespace App\Livewire\Reviews\Prpm\Penelitian\Laporan;

use App\Models\Penelitian\LaporanPenelitian;
use App\Models\User;
use Livewire\Component;

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
        $this->laporan = LaporanPenelitian::with([
            'documents',
            'proposalPenelitian.ketuaPengusul',
            'reviews.reviewer',
        ])->findOrFail($laporanId);

        $this->status = $this->laporan->status;
        $this->reviewer_id = $this->laporan->reviews->pluck('reviewer_id')->map(fn ($id) => (int) $id)->toArray();
        $this->komentar_prpm = $this->laporan->komentar_prpm;
    }

    public function removeReviewer($index)
    {
        if (isset($this->reviewer_id[$index])) {
            $reviewerId = $this->reviewer_id[$index];

            $this->laporan->reviews()->where('reviewer_id', $reviewerId)->delete();

            unset($this->reviewer_id[$index]);
            $this->reviewer_id = array_values($this->reviewer_id);

            $this->laporan = $this->laporan->fresh('reviews');
        }
    }

    public function updateStatus()
    {
        $laporan = LaporanPenelitian::findOrFail($this->laporanId);

        // ❌ Cegah perubahan jika sudah final
        if ($laporan->status === 'final') {
            $this->dispatch('toast', type: 'error', message: 'Laporan sudah final, tidak bisa diubah.');

            return;
        }

        // 🔄 Update status & komentar PRPM
        $laporan->update([
            'status' => $this->status,
            'komentar_prpm' => $this->komentar_prpm,
        ]);

        // 🔥 Hapus reviewer yang dihapus
        $laporan->reviews()->whereNotIn('reviewer_id', $this->reviewer_id)->delete();

        // 👥 Tambahkan reviewer baru
        if (! empty($this->reviewer_id)) {
            foreach ($this->reviewer_id as $reviewerId) {
                $laporan->reviews()->firstOrCreate(
                    [
                        'reviewer_id' => $reviewerId,
                        'reviewable_id' => $laporan->id,
                        'reviewable_type' => LaporanPenelitian::class,
                    ],
                    ['status' => 'pending']
                );
            }
        }

        // ✅ Cek semua reviewer sudah approve
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
            } else {
                $this->dispatch('toast', type: 'error', message: 'Belum semua reviewer menyetujui proposal.');
                return;
            }
        }

        // 🔄 Refresh data
        $this->laporan = $laporan->fresh(['reviews.reviewer']);

        $this->dispatch('toast', type: 'success', message: 'Status laporan berhasil diperbarui.');
    }

    public function render()
    {
        $reviewers = User::role('reviewer')->get();
        $totalReviewer = $this->laporan->reviews->count();
        $approvedCount = $this->laporan->reviews->where('status', 'approved')->count();
        $allApproved = $totalReviewer > 0 && $approvedCount === $totalReviewer;

        return view('livewire.reviews.prpm.penelitian.laporan.reviews-form', [
            'laporan' => $this->laporan,
            'reviewers' => $reviewers,
            'allApproved' => $allApproved,
        ]);
    }
}

<?php

namespace App\Traits;

trait HasKetuaPengusul
{
    /**
     * Ambil User ketua pengusul secara dinamis dari model apa pun
     */
    public function getKetuaPengusulAttribute()
    {
        // 1. Cek relasi langsung
        if (method_exists($this, 'ketuaPengusul')) {
            return $this->ketuaPengusul()->first();
        }

        // 2. Proposal Penelitian
        if (property_exists($this, 'proposalPenelitian') && method_exists($this->proposalPenelitian, 'ketuaPengusul')) {
            return $this->proposalPenelitian->ketuaPengusul()->first();
        }

        // 3. Laporan Penelitian
        if (property_exists($this, 'laporanPenelitian') && method_exists($this->laporanPenelitian, 'ketuaPengusul')) {
            return $this->laporanPenelitian->ketuaPengusul()->first();
        }

        // 4. Proposal Pengabdian
        if (property_exists($this, 'proposalPengabdian') && method_exists($this->proposalPengabdian, 'ketuaPengusul')) {
            return $this->proposalPengabdian->ketuaPengusul()->first();
        }

        // 5. Laporan Pengabdian
        if (property_exists($this, 'laporanPengabdian') && method_exists($this->laporanPengabdian, 'ketuaPengusul')) {
            return $this->laporanPengabdian->ketuaPengusul()->first();
        }

        return null;
    }

    /**
     * Ambil rumpun ilmu secara dinamis
     */
  public function getRumpunIlmuAttribute()
{
    // Kalau model ini sendiri punya kolom rumpun_ilmu
    if ($this->getAttribute('rumpun_ilmu')) {
        return $this->getAttribute('rumpun_ilmu');
    }

    // Kalau model ini LaporanPenelitian/Pengabdian, ambil dari proposal terkait
    if (method_exists($this, 'proposalPenelitian') && $this->proposalPenelitian) {
        return $this->proposalPenelitian->getAttribute('rumpun_ilmu');
    }

    if (method_exists($this, 'proposalPengabdian') && $this->proposalPengabdian) {
        return $this->proposalPengabdian->getAttribute('rumpun_ilmu');
    }

    return null;
}



    /**
     * Review route dinamis
     */
    public function getReviewRouteAttribute(): string
    {
        return match(true) {
            $this instanceof \App\Models\Penelitian\ProposalPenelitian =>
                route('ketua-prpm.review.penelitian.proposal.form', $this->id),
            $this instanceof \App\Models\Penelitian\LaporanPenelitian =>
                route('ketua-prpm.review.penelitian.laporan.form', $this->id),
            $this instanceof \App\Models\Pengabdian\ProposalPengabdian =>
                route('ketua-prpm.review.pengabdian.proposal.form', $this->id),
            $this instanceof \App\Models\Pengabdian\LaporanPengabdian =>
                route('ketua-prpm.review.pengabdian.laporan.form', $this->id),
            default => '#',
        };
    }
}

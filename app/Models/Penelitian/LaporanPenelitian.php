<?php

namespace App\Models\Penelitian;

use App\Models\Document;
use App\Models\Penelitian\ProposalPenelitian;
use App\Models\Review\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPenelitian extends Model
{
    use HasFactory;

    protected $table = 'laporan_penelitians';

    protected $fillable = [
        'judul',
        'proposal_penelitian_id',
        'metode_penelitian',
        'ringkasan_laporan',
        'abstrak',
        'kata_kunci',
        'status',
        'komentar_prpm',
    ];

    // Relasi ke proposal
    public function proposalPenelitian()
    {
        return $this->belongsTo(ProposalPenelitian::class, 'proposal_penelitian_id');
    }

    // Relasi ke review laporan
    // App\Models\LaporanPenelitian.php
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}

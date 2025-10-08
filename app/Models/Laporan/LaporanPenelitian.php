<?php

namespace App\Models\Laporan;

use App\Models\Document;
use App\Models\Review\Review;
use App\Models\Proposal\Proposal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanPenelitian extends Model
{
        use HasFactory;
protected $table = 'laporan_penelitian';
    protected $fillable = [
        'proposal_id',
        'metode_penelitian',
        'ringkasan_laporan',
        'abstrak',
        'kata_kunci',
        'status_prpm',
        'komentar_prpm',
    ];

    // Relasi ke proposal
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
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
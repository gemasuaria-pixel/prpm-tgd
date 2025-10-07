<?php

namespace App\Models\Laporan;

use App\Models\Proposal\Proposal;
use App\Models\Review\LaporanReview;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Document;

class Laporan extends Model
{
        use HasFactory;

    protected $fillable = [
        'proposal_id',
        'file_laporan',
        'link_jurnal',
        'status_prpm',
        'status_final_prpm',
        'komentar_prpm',
    ];

    // Relasi ke proposal
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    // Relasi ke review laporan
    public function reviews()
    {
        return $this->hasMany(LaporanReview::class);
    }

     public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
<?php

namespace App\Models\Pengabdian;

use App\Models\User;
use App\Models\Document;
use App\Models\Review\Review;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pengabdian\ProposalPengabdian;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanPengabdian extends Model
{
    use HasFactory;
    protected $table = 'laporan_pengabdians';

    protected $fillable = [
         'proposal_pengabdian_id',
        'judul',
        'tahun_pelaksanaan',
        'abstrak',
        'kata_kunci',
        'metode_penelitian',
        'ringkasan',
        'external_links',
        'status',
        'komentar_reviewer',
        'komentar_prpm',
    ];

    /**
     * Relasi ke proposal pengabdian
     */
    public function proposalPengabdian()
    {
        return $this->belongsTo(ProposalPengabdian::class, 'proposal_pengabdian_id');
    }

    /**
     * Relasi ke review (polymorphic)
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    
    public function reviewers()
    {
        return $this->belongsToMany(
            User::class,
            'reviews',           // tabel pivot
            'reviewable_id',     // FK ke proposal
            'reviewer_id'        // FK ke users
        )->wherePivot('reviewable_type', self::class);
    }

    /**
     * Relasi ke dokumen (polymorphic)
     */
    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

}
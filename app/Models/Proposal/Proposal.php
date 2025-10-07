<?php

namespace App\Models\Proposal;

use App\Models\User;
use App\Models\Mitra;
use App\Models\Member;
use App\Models\Document;
use App\Models\Review\Review;
use App\Models\InfoPenelitian;
use App\Models\Laporan\Laporan;
use App\Models\Review\ProposalReviews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposal extends Model
{
    use HasFactory;
    protected $table = 'proposal';
    protected $fillable = [
        'dosen_id',
        'jenis',
        'judul',
        'tahun_pelaksanaan',
        'ketua_pengusul',
        'rumpun_ilmu',
        'bidang_penelitian',
        'kata_kunci',
        'abstrak',
        'pernyataan',
        'status_prpm',
        'status_final_prpm',
        'komentar_prpm',
        'luaran_tambahan_dijanjikan'
    ];

    // Relasi ke dosen pengusul (user)
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    // Relasi ke member proposal
    public function member()
    {
        return $this->hasMany(Member::class);
    }

    // Relasi ke mitra (khusus pengabdian)
    public function mitra()
    {
        return $this->hasOne(Mitra::class);
    }

    // Relasi ke review proposal
   public function reviews()
{
    return $this->morphMany(Review::class, 'reviewable');
}


    // Relasi ke laporan
    public function Laporan()
    {
        return $this->hasMany(Laporan::class);
    }
      public function documents()
    {
    
        return $this->morphMany(Document::class, 'documentable');
    }
    public function infoPenelitian()
{
    return $this->hasOne(InfoPenelitian::class);
}

// Proposal.php atau ProposalPenelitian.php
public function members()
{
    return $this->morphMany(\App\Models\Member::class, 'memberable');
}

}

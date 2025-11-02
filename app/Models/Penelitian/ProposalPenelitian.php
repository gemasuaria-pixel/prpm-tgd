<?php

namespace App\Models\Penelitian;

use App\Models\User;
use App\Models\Anggota;
use App\Models\Document;
use App\Models\Review\Review;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penelitian\LaporanPenelitian;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalPenelitian extends Model
{
    use HasFactory;
    protected $table = 'proposal_penelitians';
    protected $fillable = [
        'ketua_pengusul_id',
        'judul',
        'tahun_pelaksanaan',
        'rumpun_ilmu',
        'bidang_penelitian',
        'kata_kunci',
        'abstrak',
        'syarat_ketentuan',
        'status',
        'komentar_prpm',
        'luaran_tambahan_dijanjikan'
    ];

    // Relasi ke dosen pengusul (user)
    public function ketuaPengusul()
    {
        return $this->belongsTo(User::class, 'ketua_pengusul_id');
    }

    // Relasi ke review proposal
   public function reviews()
{
    return $this->morphMany(Review::class, 'reviewable');
}
    // Relasi ke LaporanPenelitian
    public function laporanPenelitian()
    {
          return $this->hasOne(LaporanPenelitian::class, 'proposal_penelitian_id');
    }
      public function documents()
    {
    
        return $this->morphMany(Document::class, 'documentable');
    }

// ProposalPenelitian.php
public function anggota()
{
    return $this->morphMany(Anggota::class, 'proposable');
}

}

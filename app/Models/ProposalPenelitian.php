<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalPenelitian extends Model
{
    protected $table = 'proposal_penelitian';

    protected $fillable = [
        'judul_penelitian', 'tahun_pelaksanaan', 'ketua_pengusul',
        'rumpun_ilmu', 'bidang_penelitian', 'kata_kunci',
        'abstrak', 'luaran_tambahan', 'pernyataan', 'status_prpm', 'status_final', 'komentar_prpm'
        
    ];
    const STATUS_PENDING  = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_REVISION = 'revision';


    public function anggota()
    {
        return $this->hasMany(AnggotaPenelitian::class, 'proposal_id');
    }

    public function dokumen()
{
    return $this->hasMany(DokumenPenelitian::class, 'proposal_id');
}
public function reviews()
{
    return $this->morphMany(ProposalReview::class, 'reviewable');
}

}
<?php

namespace App\Models\Pengabdian;

use App\Models\User;
use App\Models\Member;
use App\Models\Document;
use App\Models\AnggotaDosen;
use App\Models\Review\Review;
use App\Models\AnggotaMahasiswa;
use App\Traits\HasKetuaPengusul;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pengabdian\ProposalPengabdian;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanPengabdian extends Model
{
    use HasFactory;
    use HasKetuaPengusul;
    protected $table = 'laporan_pengabdians';

    protected $fillable = [
         'proposal_pengabdian_id',
        'judul',
        'tahun_pelaksanaan',
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

    /**
     * Relasi ke dokumen (polymorphic)
     */
    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

}
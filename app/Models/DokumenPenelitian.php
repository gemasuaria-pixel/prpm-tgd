<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumenPenelitian extends Model
{
    use HasFactory;

    protected $table = 'dokumen_penelitian';

    protected $fillable = [
        'proposal_id',
        'jenis_dokumen',
        'file_path',
    ];

    /**
     * Relasi ke model proposalPenelitian (many to one)
     * Setiap dokumen milik satu proposal penelitian
     */
    public function proposal()
    {
        return $this->belongsTo(ProposalPenelitian::class, 'proposal_id');
    }
}

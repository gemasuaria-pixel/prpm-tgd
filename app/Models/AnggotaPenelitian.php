<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaPenelitian extends Model
{
    protected $table = 'anggota_penelitian';

    protected $fillable = [
        'proposal_id', 'nama', 'nidn', 'alamat', 'kontak', 'urutan'
    ];

    public function proposal()
    {
        return $this->belongsTo(ProposalPenelitian::class, 'proposal_id');
    }
}
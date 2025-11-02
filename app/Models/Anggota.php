<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';

    protected $fillable = [
        'anggota_id',
        'anggota_type',
        'proposable_id',
        'proposable_type',
    ];

    // Polymorphic untuk anggota (Mahasiswa atau User/dosen)
    public function anggota()
    {
        return $this->morphTo();
    }

    // Polymorphic untuk proposal (ProposalPenelitian atau ProposalPengabdian)
    public function proposable()
    {
        return $this->morphTo();
    }
}

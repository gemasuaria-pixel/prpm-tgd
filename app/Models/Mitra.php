<?php

namespace App\Models;

use App\Models\Proposal\Proposal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mitra extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'nama_instansi',
        'alamat',
        'bidang_kerjasama',
        'kontak',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}

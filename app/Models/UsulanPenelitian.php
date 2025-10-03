<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsulanPenelitian extends Model
{
    protected $table = 'usulan_penelitian';

    protected $fillable = [
        'judul_penelitian', 'tahun_pelaksanaan', 'ketua_pengusul',
        'rumpun_ilmu', 'bidang_penelitian', 'kata_kunci',
        'abstrak', 'file_proposal', 'luaran_tambahan', 'pernyataan'
    ];

    public function anggota()
    {
        return $this->hasMany(AnggotaPenelitian::class, 'usulan_id');
    }
}
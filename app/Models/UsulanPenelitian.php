<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsulanPenelitian extends Model
{
    protected $table = 'usulan_penelitian';

    protected $fillable = [
        'judul_penelitian', 'tahun_pelaksanaan', 'ketua_pengusul',
        'rumpun_ilmu', 'bidang_penelitian', 'kata_kunci',
        'abstrak', 'luaran_tambahan', 'pernyataan', 'status', 'catatan_reviewer'
        
    ];
    const STATUS_PENDING  = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_REVISION = 'revision';


    public function anggota()
    {
        return $this->hasMany(AnggotaPenelitian::class, 'usulan_id');
    }

    public function dokumen()
{
    return $this->hasMany(DokumenPenelitian::class, 'usulan_id');
}

}
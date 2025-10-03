<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaPenelitian extends Model
{
    protected $table = 'anggota_penelitian';

    protected $fillable = [
        'usulan_id', 'nama', 'nidn', 'alamat', 'kontak', 'urutan'
    ];

    public function usulan()
    {
        return $this->belongsTo(UsulanPenelitian::class, 'usulan_id');
    }
}
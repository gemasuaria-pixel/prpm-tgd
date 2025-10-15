<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaMahasiswa extends Model
{
    protected $table = 'anggota_mahasiswa';
    protected $fillable = ['nama', 'nim', 'alamat', 'kontak'];

    public function proposable()
    {
        return $this->morphTo();
    }
}

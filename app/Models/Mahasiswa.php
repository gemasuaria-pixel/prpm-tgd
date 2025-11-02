<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    // Nama tabel sesuai migration
    protected $table = 'mahasiswa';

    protected $fillable = ['nama','nim','prodi','email','no_hp','alamat'];

public function anggota()
{
    return $this->hasMany(Anggota::class, 'mahasiswa_id');
}

}

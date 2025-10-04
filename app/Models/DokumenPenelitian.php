<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumenPenelitian extends Model
{
    use HasFactory;

    protected $table = 'dokumen_penelitian';

    protected $fillable = [
        'usulan_id',
        'jenis_dokumen',
        'file_path',
    ];

    /**
     * Relasi ke model UsulanPenelitian (many to one)
     * Setiap dokumen milik satu usulan penelitian
     */
    public function usulan()
    {
        return $this->belongsTo(UsulanPenelitian::class, 'usulan_id');
    }
}

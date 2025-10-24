<?php

namespace App\Models\Pengabdian;

use App\Models\User;
use App\Models\Document;
use App\Models\AnggotaDosen;
use App\Models\Review\Review;
use App\Models\AnggotaMahasiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalPengabdian extends Model
{
    use HasFactory;

    protected $table = 'proposal_pengabdians';


    protected $fillable = [
        'ketua_pengusul_id',
        'judul',
        'tahun_pelaksanaan',
        'rumpun_ilmu',
        'syarat_ketentuan',
        'luaran_tambahan_dijanjikan',
        'abstrak',
        'kata_kunci',
        'status',
        'komentar_prpm',
        'nama_mitra',
        'jenis_mitra',
        'alamat_mitra',
        'kontak_mitra',
        'pimpinan_mitra',
        'jumlah_anggota_kelompok',
        'pernyataan_kebutuhan',
    ];
/**
     * Relasi ke User (Ketua Pengusul)
     */
    public function ketuaPengusul()
    {
        return $this->belongsTo(User::class, 'ketua_pengusul_id');
    }

    /**
     * Relasi ke Laporan Pengabdian (One to One)
     */
    public function laporanPengabdian()
    {
        return $this->hasOne(LaporanPengabdian::class, 'proposal_pengabdian_id');
    }

    /**
     * Relasi ke review (polymorphic)
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Relasi ke dokumen (polymorphic)
     */
    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    /**
     * Relasi ke anggota (polymorphic) - jika ada anggota dosen/mahasiswa
     */
     // ProposalPengabdian.php
public function anggotaDosen()
{
    return $this->morphMany(AnggotaDosen::class, 'proposable');
}

public function anggotaMahasiswa()
{
    return $this->morphMany(AnggotaMahasiswa::class, 'proposable');
}

}



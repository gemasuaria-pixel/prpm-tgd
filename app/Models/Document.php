<?php

namespace App\Models;

use App\Models\Proposal\Proposal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $guarded = [];

    protected $fillable = [
        
        'tipe',
        'file_path',
        'link_jurnal',
    ];

    /**
     * Relasi ke model proposalPenelitian (many to one)
     * Setiap dokumen milik satu proposal penelitian
     */
    public function documentable()
    {
        return $this->morphTo();
    }
}

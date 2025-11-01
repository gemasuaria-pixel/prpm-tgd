<?php

namespace App\Models\Review;

use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'reviewable_id',    // ID dari proposal/laporan yang direview
        'reviewable_type',  // Model yang direview (Proposal atau Laporan)
        'reviewer_id',      // User yang menjadi reviewer
        'status',           // pending, layak, tidak_layak
        'komentar',         // komentar reviewer
    ];

    /**
     * Relasi polymorphic ke proposal atau laporan
     */
    public function reviewable()
    {
        return $this->morphTo();
    }

    /**
     * Relasi ke reviewer (User)
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviewable_id',
        'reviewable_type',
        'reviewer_id',
        'status',
        'komentar',
    ];

    /**
     * Polymorphic relation ke usulan (penelitian/pengabdian).
     */
    public function reviewable()
    {
        return $this->morphTo();
    }

    /**
     * Relasi ke reviewer (user).
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}

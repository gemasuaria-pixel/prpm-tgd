<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResearchProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'year',
        'discipline',
        'leader_name',
        'field_of_study',
        'keywords',
        'abstract',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}



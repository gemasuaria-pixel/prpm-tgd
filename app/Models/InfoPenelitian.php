<?php

namespace App\Models;

use App\Models\Proposal\Proposal;
use Illuminate\Database\Eloquent\Model;

class InfoPenelitian extends Model
{
    protected $table = 'info_penelitian';
 protected $fillable = [
        'bidang_penelitian',
        'abstrak',
        'kata_kunci',
    ];

    public function proposal()
{
    return $this->belongsTo(Proposal::class);
}

}

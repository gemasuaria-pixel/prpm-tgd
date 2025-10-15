<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaDosen extends Model
{
    protected $table = 'anggota_dosen';
    protected $fillable = ['user_id'];
    

    public function proposable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

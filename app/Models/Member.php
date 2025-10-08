<?php

namespace App\Models;

use App\Models\Proposal\Proposal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;
    protected $table = 'members';
    protected $fillable = [
        'tipe',
        'nama',
        'nidn',
        'nim',
        'alamat',
        'kontak',

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
     public function memberable()
    {
        return $this->morphTo();
    }
}

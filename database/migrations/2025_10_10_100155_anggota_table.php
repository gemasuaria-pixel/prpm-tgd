<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();

            // Morph untuk anggota: bisa Mahasiswa atau Dosen (User)
            $table->morphs('anggota'); // anggota_id + anggota_type

            // Morph untuk proposal: bisa ProposalPenelitian atau ProposalPengabdian
            $table->morphs('proposable'); // proposable_id + proposable_type

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};

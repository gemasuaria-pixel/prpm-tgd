<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anggota_dosen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->morphs('proposable'); // proposable_id + proposable_type
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('anggota_dosen');
    }
};

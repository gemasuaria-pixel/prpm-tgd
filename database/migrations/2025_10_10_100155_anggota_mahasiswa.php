<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anggota_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nim');
            $table->string('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->morphs('proposable'); // proposable_id + proposable_type
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_mahasiswa');
    }
};

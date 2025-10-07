<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            // 🔹 polymorphic relation ke proposal_penelitian & proposal_pengabdian
            $table->morphs('memberable'); 
            // ini akan membuat: memberable_id (bigint) dan memberable_type (string)

            $table->enum('tipe', ['dosen', 'mahasiswa']);
            $table->string('nama');
            $table->string('nidn')->nullable();
            $table->string('nim')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kontak')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};

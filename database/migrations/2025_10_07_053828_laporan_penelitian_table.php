<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_penelitian', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proposal_id')->constrained('proposal')->onDelete('cascade');
            // Tambahkan unique constraint
            $table->unique('proposal_id');
            // Informasi laporan
            $table->text('abstrak')->nullable();
            $table->string('kata_kunci')->nullable();
            $table->string('metode_penelitian')->nullable();
            $table->string('ringkasan_laporan')->nullable();
            $table->enum('status_prpm', ['pending', 'approved', 'rejected', 'revisi', 'final'])->default('pending');
            $table->text('komentar_prpm')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_penelitian');
    }
};

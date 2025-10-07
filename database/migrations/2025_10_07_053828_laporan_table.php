<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal')->onDelete('cascade');
            // Informasi laporan
            $table->string('file_laporan')->nullable(); // upload laporan (Word/PDF)
            $table->string('link_jurnal')->nullable(); // opsional


            $table->enum('status_prpm', ['pending', 'approved', 'rejected','revisi'])->default('pending');
            $table->enum('status_final_prpm', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('komentar_prpm')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};

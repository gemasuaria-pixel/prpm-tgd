<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proposal', function (Blueprint $table) {
            $table->id();

            // Relasi ke dosen pengusul
            $table->foreignId('dosen_id')->constrained('users')->onDelete('cascade');

            // Jenis kegiatan
            $table->enum('jenis', ['penelitian', 'pengabdian']);

            // Identitas proposal
            $table->string('judul');
            $table->year('tahun_pelaksanaan'); // contoh: 2025
            $table->string('ketua_pengusul'); // bisa juga pakai relasi kalau mau lebih kompleks
            $table->string('rumpun_ilmu')->nullable();
            $table->string('kata_kunci')->nullable();
            $table->text('abstrak')->nullable();
            $table->text('pernyataan')->nullable(); // misal: pernyataan keaslian
            $table->text('luaran_tambahan_dijanjikan')->nullable(); // misal: pernyataan keaslian
            // Status dan hasil evaluasi PRPM
            $table->enum('status_prpm', ['pending', 'approved', 'rejected','revisi'])->default('pending');
            $table->enum('status_final_prpm', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('komentar_prpm')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal');
    }
};

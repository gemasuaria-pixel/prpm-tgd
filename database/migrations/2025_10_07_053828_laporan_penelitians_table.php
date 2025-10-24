<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_penelitians', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->foreignId('proposal_penelitian_id')
                ->constrained('proposal_penelitians')
                ->onDelete('cascade');
            $table->unique('proposal_penelitian_id'); // satu laporan per proposal
            $table->text('abstrak')->nullable();
            $table->string('kata_kunci')->nullable();
            $table->string('metode_penelitian')->nullable();
            $table->text('ringkasan_laporan')->nullable();
            $table->enum('status', [
                'draft',
                'revisi',
                'rejected',
                'menunggu_validasi_prpm',
                'menunggu_validasi_reviewer',
                'approved_by_reviewer',
                'final',
            ])->default('pending');
            $table->text('komentar_prpm')->nullable();
            // Tambahan: JSON untuk link eksternal (video / jurnal)
            $table->json('external_links')->nullable()
                ->comment('Simpan link video/jurnal dalam format JSON: [{"type":"video","url":"..."},{"type":"jurnal","url":"..."}]');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_penelitians');
    }
};

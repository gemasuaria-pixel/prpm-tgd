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
        Schema::create('laporan_pengabdians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_pengabdian_id')
                ->constrained('proposal_pengabdians')
                ->onDelete('cascade');
            $table->unique('proposal_pengabdian_id');
            $table->string('judul');
            $table->year('tahun_pelaksanaan');
            $table->text('ringkasan')->nullable();
            // Tambahan: JSON untuk link eksternal (video / jurnal)
            $table->json('external_links')->nullable()
                ->comment('Simpan link video/jurnal dalam format JSON: [{"type":"video","url":"..."},{"type":"jurnal","url":"..."}]');

            $table->enum('status', [
                'draft',
                'revisi',
                'rejected',
                'menunggu_validasi_prpm',
                'menunggu_validasi_reviewer',
                'approved_by_reviewer',
                'final',
            ])->default('menunggu_validasi_prpm');
            $table->text('komentar_reviewer')->nullable();
            $table->text('komentar_prpm')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pengabdians');
    }
};

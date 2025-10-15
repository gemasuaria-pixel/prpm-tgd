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
            $table->string('file_laporan')->nullable();
            $table->string('link_video')->nullable();
            $table->enum('status', [
                'draft',
                'menunggu_validasi_prpm',
                'revisi',
                'approved_by_prpm',
                'rejected',
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

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
        Schema::create('proposal_penelitians', function (Blueprint $table) {
    $table->id();
    $table->foreignId('ketua_pengusul_id')->constrained('users')->onDelete('cascade');
    $table->string('judul');
    $table->year('tahun_pelaksanaan');
    $table->string('rumpun_ilmu')->nullable();
    $table->boolean('syarat_ketentuan')->default(false)->comment('Persetujuan syarat & ketentuan');
    $table->text('luaran_tambahan_dijanjikan')->nullable();
    $table->string('bidang_penelitian')->nullable();
    $table->text('abstrak')->nullable();
    $table->string('kata_kunci')->nullable();
    $table->enum('status', [
        'draft',
        'menunggu_validasi_prpm',
        'revisi',
        'approved_by_prpm',
        'menunggu_validasi_reviewer',
        'approved_by_prpm',
        'rejected',
        'final'
    ])->default('menunggu_validasi_prpm');
    $table->text('komentar_prpm')->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_penelitians');
    }
};

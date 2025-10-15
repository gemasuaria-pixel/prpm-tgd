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
    $table->foreignId('proposal_penelitian_id')
        ->constrained('proposal_penelitians')
        ->onDelete('cascade');
    $table->unique('proposal_penelitian_id'); // satu laporan per proposal
    $table->text('abstrak')->nullable();
    $table->string('kata_kunci')->nullable();
    $table->string('metode_penelitian')->nullable();
    $table->text('ringkasan_laporan')->nullable();
    $table->enum('status', [
        'pending',
        'menunggu_validasi_prpm',
        'revisi',
        'approved_by_prpm',
        'rejected',
        'final'
    ])->default('pending');
    $table->text('komentar_prpm')->nullable();
    $table->timestamps();
});


    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_penelitians');
    }
};

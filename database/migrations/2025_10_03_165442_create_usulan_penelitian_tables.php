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
        // Tabel usulan_penelitian
        Schema::create('usulan_penelitian', function (Blueprint $table) {
            $table->id();
            $table->string('judul_penelitian');
            $table->year('tahun_pelaksanaan');
            $table->string('ketua_pengusul', 150);
            $table->string('rumpun_ilmu', 100);
            $table->string('bidang_penelitian', 100)->nullable();
            $table->string('kata_kunci');
            $table->text('abstrak');
            $table->enum('luaran_tambahan', ['Publikasi Jurnal', 'Hak Kekayaan Intelektual', 'Buku Ajar'])->nullable();
            $table->boolean('pernyataan')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected', 'revision'])->default('pending');
            $table->text('catatan_reviewer')->nullable(); // optional, untuk memberi feedback
            $table->timestamps();
        });

        // Tabel anggota_penelitian
        Schema::create('anggota_penelitian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usulan_id')->constrained('usulan_penelitian')->onDelete('cascade');
            $table->string('nama', 150);
            $table->string('nidn', 50)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('kontak', 50)->nullable();
            $table->integer('urutan')->default(0); // untuk drag & drop order
            $table->timestamps();
        });

        // Opsional: tabel dokumen tambahan
        Schema::create('dokumen_penelitian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usulan_id')->constrained('usulan_penelitian')->onDelete('cascade');
            $table->string('jenis_dokumen', 100); // contoh: Proposal, HKI, Buku Ajar
            $table->string('file_path', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_penelitian');
        Schema::dropIfExists('anggota_penelitian');
        Schema::dropIfExists('usulan_penelitian');
    }
};

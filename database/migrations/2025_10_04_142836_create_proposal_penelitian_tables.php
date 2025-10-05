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
        // Tabel proposal_penelitian
        Schema::create('proposal_penelitian', function (Blueprint $table) {
            $table->id();
            $table->string('judul_penelitian');
            $table->year('tahun_pelaksanaan');
            $table->string('ketua_pengusul', 150);
            $table->string('rumpun_ilmu', 100);
            $table->string('bidang_penelitian', 100)->nullable();
            $table->string('kata_kunci');
            $table->text('abstrak');
            $table->boolean('pernyataan')->default(false);
            $table->text('komentar_prpm')->nullable();
            $table->string('luaran_tambahan')->nullable();
            // status berlapis
            $table->enum('status_prpm', ['pending', 'approved', 'rejected', 'revision'])->default('pending');
            $table->enum('status_final', ['pending', 'layak', 'tidak_layak'])->default('pending');

            $table->timestamps();
        });

        // Tabel anggota_penelitian
        Schema::create('anggota_penelitian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal_penelitian')->onDelete('cascade');
            $table->string('nama', 150);
            $table->string('nidn', 50)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('kontak', 50)->nullable();
            $table->integer('urutan')->default(0); // untuk drag & drop order
            $table->timestamps();
        });

        // Tabel dokumen tambahan
        Schema::create('dokumen_penelitian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal_penelitian')->onDelete('cascade');
            $table->enum('jenis_dokumen', ['proposal', 'hki', 'buku_ajar', 'lainnya']);
            $table->string('file_path', 255);
            $table->timestamps();
        });

        // Tabel luaran tambahan (lebih fleksibel daripada enum tunggal)
        Schema::create('luaran_penelitian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal_penelitian')->onDelete('cascade');
            $table->enum('jenis_luaran', ['Publikasi Jurnal', 'Hak Kekayaan Intelektual', 'Buku Ajar']);
            $table->string('keterangan')->nullable(); // misalnya judul jurnal atau nomor HKI
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('luaran_penelitian');
        Schema::dropIfExists('proposal_reviews');
        Schema::dropIfExists('dokumen_penelitian');
        Schema::dropIfExists('anggota_penelitian');
        Schema::dropIfExists('proposal_penelitian');
    }
};

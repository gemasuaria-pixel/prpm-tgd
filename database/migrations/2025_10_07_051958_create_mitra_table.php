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
        Schema::create('mitra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposal')->onDelete('cascade');

            // Sesuai field form:
            $table->string('nama_mitra'); // contoh: PT Mencari Cinta
            $table->string('jenis_kelompok'); // contoh: Kelompok Tani, UMKM, Sekolah, dst
            $table->string('alamat_lengkap'); // contoh: Jl. Sukoharjo Kec. Medan Barat Kota Medan
            $table->string('kontak_mitra'); // contoh: +6281221223445
            $table->string('pimpinan_mitra'); // contoh: Budiman Sanoyo, S.E.
            $table->string('jumlah_anggota_kelompok'); // contoh: 6 Orang
            $table->text('pernyataan_kebutuhan'); // deskripsi kebutuhan oleh mitra

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mitra');
    }
};

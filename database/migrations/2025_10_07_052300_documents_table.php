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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            // 🔹 relasi polymorphic
            $table->unsignedBigInteger('documentable_id');
            $table->string('documentable_type');
            // 🔹 atribut dokumen
            $table->enum('tipe', [
                'proposal_penelitian',
                'proposal_pengabdian',
                'laporan_penelitian',
                'laporan_pengabdian',
                'jurnal',
            ]);
            $table->string('file_path')->nullable();
            $table->string('link_jurnal')->nullable();
            $table->timestamps();

            // 🔹 (opsional) buat index untuk efisiensi query
            $table->index(['documentable_id', 'documentable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};

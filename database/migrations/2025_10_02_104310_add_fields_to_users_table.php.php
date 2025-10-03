<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Identitas
            $table->string('nidn_nidk')->nullable()->after('email');
            $table->string('no_ktp')->nullable()->after('nidn_nidk');

            // Data pribadi
            $table->string('tempat_lahir')->nullable()->after('no_ktp');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
 
            // Akademik
            $table->string('klaster')->nullable()->after('tanggal_lahir');
            $table->string('kelompok_pt_binaan')->nullable()->after('klaster');
            $table->string('institusi')->default('STMIK Triguna Dharma')->after('kelompok_pt_binaan');
            $table->string('program_studi')->nullable()->after('institusi');
            $table->string('jenjang_pendidikan')->nullable()->after('program_studi');
            $table->string('jabatan_akademik')->nullable()->after('jenjang_pendidikan');

            // Kontak
            $table->string('no_hp')->nullable()->after('jabatan_akademik');
            $table->text('alamat')->nullable()->after('no_hp'); // Tambahan alamat
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nidn_nidk',
                'no_ktp',
                'tempat_lahir',
                'tanggal_lahir',
                'klaster',
                'kelompok_pt_binaan',
                'institusi',
                'program_studi',
                'jenjang_pendidikan',
                'jabatan_akademik',
                'no_hp',
                'alamat', 
            ]);
        });
    }
};

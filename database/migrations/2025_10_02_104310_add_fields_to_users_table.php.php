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
        Schema::table('users', function (Blueprint $table) {
            $table->string('full_name')->after('name')->nullable();
            $table->string('nidn')->after('full_name')->nullable()->unique();
            $table->string('tempat_lahir')->after('nidn')->nullable();
            $table->date('tanggal_lahir')->after('tempat_lahir')->nullable();
            $table->string('institusi')->after('tanggal_lahir')->nullable()->default('STMIK Triguna Dharma');
            $table->string('program_studi')->after('institusi')->nullable();
            $table->string('no_hp')->after('program_studi')->nullable();
            $table->text('alamat')->after('no_hp')->nullable();
            $table->string('kontak')->after('alamat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'full_name',
                'nidn',
                'tempat_lahir',
                'tanggal_lahir',
                'institusi',
                'program_studi',
                'no_hp',
                'alamat',
                'kontak',
            ]);
        });
    }
};

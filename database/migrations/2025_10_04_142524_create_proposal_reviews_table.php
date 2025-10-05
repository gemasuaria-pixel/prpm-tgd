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
        Schema::create('proposal_reviews', function (Blueprint $table) {
            $table->id();

            // Polymorphic relation ke usulan penelitian/pengabdian
            $table->morphs('reviewable'); // menghasilkan reviewable_id (bigint) + reviewable_type (varchar)

            // Reviewer (user dosen)
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');

            // Status hasil review
            $table->enum('status', ['pending', 'layak', 'tidak_layak'])->default('pending');

            // Komentar reviewer
            $table->text('komentar')->nullable();

            $table->timestamps();

            // Unique constraint biar reviewer sama tidak bisa review 2x untuk 1 usulan
            $table->unique(['reviewable_id', 'reviewable_type', 'reviewer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_reviews');
    }
};

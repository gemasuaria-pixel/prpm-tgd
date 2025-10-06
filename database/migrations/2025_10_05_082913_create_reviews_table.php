<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('reviewable_id');
            $table->string('reviewable_type');
            $table->enum('status', ['pending', 'approved', 'rejected', 'revision'])->default('pending');
            $table->text('komentar')->nullable();
            $table->integer('nilai')->nullable();
            $table->timestamps();

            $table->index(['reviewable_id', 'reviewable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

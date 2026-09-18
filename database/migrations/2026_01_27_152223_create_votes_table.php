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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('poll_id')->constrained()->onDelete('cascade');
            $table->foreignId('candidate_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('vote_type', ['válido', 'no sabe', 'ninguno'])->default('válido');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('fingerprint');
            $table->string('poll_token')->nullable();
            $table->string('session_id')->nullable();
            $table->string('composite_hash', 64)->unique();
            $table->boolean('is_suspicious')->default(false);
            $table->timestamps();

            $table->index(['poll_id', 'fingerprint']);
            $table->unique(['poll_id', 'poll_token']);
            $table->index(['poll_id', 'composite_hash']);
            $table->index(['poll_id', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};

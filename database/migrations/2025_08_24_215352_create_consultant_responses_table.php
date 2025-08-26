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
        Schema::create('consultant_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('attempts');
            $table->foreignId('consultant_id')->constrained('users');
            $table->text('response_text');
            $table->text('recommendations')->nullable();
            $table->boolean('is_urgent')->default(false);
            $table->timestamp('sent_at');
            $table->timestamps();

            $table->index(['attempt_id']);
            $table->index(['consultant_id']);
            $table->unique(['attempt_id']); // One response per attempt
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultant_responses');
    }
};

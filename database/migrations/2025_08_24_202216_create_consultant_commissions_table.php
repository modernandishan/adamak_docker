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
        Schema::create('consultant_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultant_id')->constrained('users');
            $table->foreignId('attempt_id')->constrained('attempts');
            $table->foreignId('test_id')->constrained('tests');
            $table->decimal('test_amount', 12, 2); // مبلغ آزمون
            $table->decimal('commission_percentage', 5, 2); // درصد کمیسیون مشاور
            $table->decimal('commission_amount', 12, 2); // مبلغ کمیسیون
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->timestamp('earned_at');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['consultant_id', 'status']);
            $table->index(['attempt_id']);
            $table->index(['test_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultant_commissions');
    }
};

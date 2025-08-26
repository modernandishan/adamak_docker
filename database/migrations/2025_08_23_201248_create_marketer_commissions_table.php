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
        Schema::create('marketer_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marketer_id')->constrained('users');
            $table->foreignId('referred_user_id')->constrained('users');
            $table->foreignId('referral_id')->constrained('referrals');
            $table->string('commission_source'); // 'test_purchase', 'wallet_charge', etc.
            $table->unsignedBigInteger('source_id'); // ID of the purchase/transaction
            $table->decimal('original_amount', 12, 2);
            $table->decimal('commission_percentage', 5, 2);
            $table->decimal('commission_amount', 12, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->timestamp('earned_at');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['marketer_id', 'status']);
            $table->index(['commission_source', 'source_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketer_commissions');
    }
};

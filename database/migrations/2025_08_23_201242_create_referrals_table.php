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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marketer_id')->constrained('users');
            $table->foreignId('referred_user_id')->nullable()->constrained('users');
            $table->string('referral_token')->unique();
            $table->ipAddress('visitor_ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('clicked_at');
            $table->timestamp('registered_at')->nullable();
            $table->timestamps();

            $table->index(['marketer_id', 'clicked_at']);
            $table->index('referral_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};

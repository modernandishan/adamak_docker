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
            $table->string('referral_token')->unique()->nullable();
            $table->decimal('commission_percentage', 5, 2)->default(10.00);
            $table->foreignId('referred_by')->nullable()->constrained('users');
            $table->timestamp('referral_cookie_expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['referral_token', 'commission_percentage', 'referred_by', 'referral_cookie_expires_at']);
        });
    }
};

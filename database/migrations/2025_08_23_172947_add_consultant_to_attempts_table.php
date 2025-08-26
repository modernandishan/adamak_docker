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
        Schema::table('attempts', function (Blueprint $table) {
            $table->foreignId('assigned_consultant_id')->nullable()->after('family_id')->constrained('users')->onDelete('set null');
            $table->timestamp('assigned_at')->nullable()->after('assigned_consultant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attempts', function (Blueprint $table) {
            $table->dropForeign(['assigned_consultant_id']);
            $table->dropColumn(['assigned_consultant_id', 'assigned_at']);
        });
    }
};

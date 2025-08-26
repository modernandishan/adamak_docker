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
        Schema::table('consultant_biographies', function (Blueprint $table) {
            // Remove the hourly_rate column
            $table->dropColumn('hourly_rate');

            // Add the new test_commission_percentage column
            $table->decimal('test_commission_percentage', 5, 2)->default(50.00)->after('consultation_methods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultant_biographies', function (Blueprint $table) {
            // Remove the test_commission_percentage column
            $table->dropColumn('test_commission_percentage');

            // Add back the hourly_rate column
            $table->string('hourly_rate')->nullable()->after('consultation_methods');
        });
    }
};

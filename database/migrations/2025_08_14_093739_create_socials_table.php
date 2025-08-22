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
        Schema::create('socials', function (Blueprint $table) {
            $table->id();

            // General Information
            $table->string('title');
            $table->text('short_description')->nullable();

            // Media and Links
            $table->string('logo');
            $table->string('link');

            // Flags and Options
            $table->boolean('is_active')->default(true);

            // Timestamps and Soft Deletes
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socials');
    }
};

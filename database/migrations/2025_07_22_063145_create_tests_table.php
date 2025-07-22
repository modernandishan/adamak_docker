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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_category_id')->constrained('test_categories')->onDelete('cascade');

            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['Draft', 'Published', 'Archived']);
            $table->boolean('is_need_family')->default(false);
            $table->decimal('price', 10)->default(0);
            $table->decimal('sale', 10)->default(0);
            $table->integer('required_minutes')->default(0);
            $table->integer('min_age')->default(0);
            $table->integer('max_age')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('admin_note')->nullable();
            $table->string('type')->nullable();
            $table->string('catalog')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};

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

            $table->string('title')->index();
            $table->string('slug')->unique()->index();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['Draft', 'Published', 'Archived'])->default('Draft')->index();
            $table->boolean('is_need_family')->default(false)->index();
            $table->integer('price')->default(0);
            $table->integer('sale')->default(0);
            $table->integer('required_minutes')->default(0)->index();
            $table->integer('min_age')->default(0)->index();
            $table->integer('max_age')->default(100)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->text('admin_note')->nullable();
            $table->string('type')->nullable()->index();
            $table->string('catalog')->nullable()->index();
            $table->integer('sort_order')->default(0)->index();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();

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

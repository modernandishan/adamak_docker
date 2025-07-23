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
        Schema::create('seo_meta', function (Blueprint $table) {
            $table->id();

            // Polymorphic relation
            $table->morphs('model');

            // General SEO fields
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->text('image')->nullable(); // تبدیل به TEXT
            $table->string('author')->nullable();
            $table->string('robots')->nullable();
            $table->string('canonical_url')->nullable();
            $table->json('keywords')->nullable();

            // Social Media SEO
            $table->string('facebook_title')->nullable();
            $table->string('facebook_description')->nullable();
            $table->text('facebook_image')->nullable(); // تبدیل به TEXT
            $table->string('twitter_title')->nullable();
            $table->string('twitter_description')->nullable();
            $table->text('twitter_image')->nullable(); // تبدیل به TEXT
            $table->string('open_graph_title')->nullable();
            $table->string('open_graph_description')->nullable();
            $table->text('open_graph_image')->nullable(); // تبدیل به TEXT

            // Structured data (Schema)
            $table->string('schema_type')->nullable();
            $table->json('schema_data')->nullable();

            // Advanced SEO fields
            $table->string('priority')->nullable();
            $table->boolean('sitemap_include')->default(true);
            $table->string('sitemap_priority')->nullable();
            $table->string('sitemap_changefreq')->nullable();

            // Product-specific SEO fields
            $table->integer('price')->nullable();
            $table->integer('sale_price')->nullable();
            $table->string('currency')->default('IRT');
            $table->string('availability')->nullable();
            $table->string('sku')->nullable();
            $table->string('product_condition')->nullable();

            // Additional fields for record tracking
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_metas');
    }
};

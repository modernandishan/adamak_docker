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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();

            $table->string('title');
            $table->longText('description')->nullable();
            $table->enum('type', [
                'text',
                'upload',
            ])->index();

            // تنظیمات سوال
            $table->json('settings')->nullable()->comment('تنظیمات اضافی سوال به صورت JSON');
            $table->json('options')->nullable()->comment('گزینه‌های سوال');

            // تنظیمات نمایش
            $table->string('image')->nullable();
            $table->boolean('is_required')->default(true);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            // توضیحات و راهنمایی
            $table->text('hint')->nullable()->comment('راهنمای سوال');
            $table->text('explanation')->nullable()->comment('توضیح پاسخ صحیح');
            $table->text('admin_note')->nullable();

            // مدیریت زمانی
            $table->softDeletes();
            $table->timestamps();

            // ایندکس‌ها
            $table->index(['test_id', 'type']);
            $table->index(['test_id', 'sort_order']);
            $table->index(['test_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};

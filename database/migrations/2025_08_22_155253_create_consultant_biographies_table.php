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
        Schema::create('consultant_biographies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('professional_title')->nullable(); // عنوان شغلی
            $table->text('bio'); // بیوگرافی اصلی
            $table->json('specialties')->nullable(); // تخصص‌ها
            $table->json('education')->nullable(); // تحصیلات
            $table->json('certifications')->nullable(); // گواهینامه‌ها و مدارک
            $table->json('work_experience')->nullable(); // سابقه کاری
            $table->json('languages')->nullable(); // زبان‌ها
            $table->text('services_offered')->nullable(); // خدمات ارائه شده
            $table->json('consultation_methods')->nullable(); // روش‌های مشاوره (حضوری، آنلاین، تلفنی)
            $table->string('hourly_rate')->nullable(); // نرخ ساعتی
            $table->text('approach')->nullable(); // رویکرد مشاوره
            $table->json('availability')->nullable(); // ساعات کاری
            $table->string('phone')->nullable(); // تلفن تماس
            $table->string('email')->nullable(); // ایمیل تماس
            $table->json('social_media')->nullable(); // شبکه‌های اجتماعی
            $table->string('website')->nullable(); // وب‌سایت شخصی
            $table->text('achievements')->nullable(); // دستاورها و افتخارات
            $table->boolean('is_public')->default(true); // نمایش عمومی پروفایل
            $table->timestamps();

            $table->unique('user_id'); // هر کاربر یک بیوگرافی
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultant_biographies');
    }
};

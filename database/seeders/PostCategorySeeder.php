<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use App\Models\SeoMeta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $categories = [
            [
                'title' => 'روانشناسی',
                'slug' => 'psychology',
                'description' => 'مقالات و مطالب مرتبط با روانشناسی و رفتار انسان',
                'tags' => ['روانشناسی', 'رفتار', 'ذهن'],
                'seo_meta' => [
                    'title' => 'مقالات روانشناسی - بلاگ آداماک',
                    'description' => 'آخرین مقالات و مطالب روانشناسی برای درک بهتر رفتار انسان',
                    'keywords' => ['psychology', 'روانشناسی', 'رفتار انسانی'],
                ],
            ],
            [
                'title' => 'توسعه فردی',
                'slug' => 'personal-development',
                'description' => 'راهکارها و تکنیک‌های توسعه فردی و خودسازی',
                'tags' => ['توسعه فردی', 'خودسازی', 'رشد شخصی'],
                'seo_meta' => [
                    'title' => 'مقالات توسعه فردی - راهکارهای خودسازی',
                    'description' => 'بهترین روش‌های توسعه فردی و خودسازی',
                    'keywords' => ['personal development', 'توسعه فردی', 'self improvement'],
                ],
            ],
            [
                'title' => 'مشاوره شغلی',
                'slug' => 'career-counseling',
                'description' => 'راهنمایی‌ها و نکات مربوط به انتخاب شغل و پیشرفت حرفه‌ای',
                'tags' => ['مشاوره شغلی', 'کاریابی', 'حرفه'],
                'seo_meta' => [
                    'title' => 'مشاوره شغلی - راهنمای انتخاب شغل',
                    'description' => 'بهترین راهکارها برای انتخاب شغل و پیشرفت در کار',
                    'keywords' => ['career counseling', 'مشاوره شغلی', 'job guidance'],
                ],
            ],
            [
                'title' => 'آزمون‌ها و تست‌ها',
                'slug' => 'tests-and-assessments',
                'description' => 'معرفی و تحلیل انواع آزمون‌های روانشناسی و شخصیت‌شناسی',
                'tags' => ['آزمون', 'تست', 'ارزیابی'],
                'seo_meta' => [
                    'title' => 'معرفی آزمون‌ها و تست‌های روانشناسی',
                    'description' => 'آشنایی با انواع تست‌های شخصیت‌شناسی و کاربردهای آن‌ها',
                    'keywords' => ['psychological tests', 'آزمون روانشناسی', 'personality tests'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $seoData = $categoryData['seo_meta'];
            unset($categoryData['seo_meta']);

            $category = PostCategory::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );

            // Create SEO Meta for category
            SeoMeta::firstOrCreate([
                'model_type' => PostCategory::class,
                'model_id' => $category->id,
            ], $seoData);
        }
    }
}

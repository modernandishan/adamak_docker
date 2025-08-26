<?php

namespace Database\Seeders;

use App\Models\SeoMeta;
use App\Models\TestCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $categories = [
            [
                'title' => 'آزمون‌های شخصیت‌شناسی',
                'slug' => 'personality-tests',
                'description' => 'آزمون‌هایی برای شناخت انواع شخصیت و ویژگی‌های فردی',
                'is_active' => true,
                'sort_order' => 1,
                'seo_meta' => [
                    'title' => 'آزمون‌های شخصیت‌شناسی آنلاین - تست خودشناسی',
                    'description' => 'با آزمون‌های تخصصی شخصیت‌شناسی، خود را بهتر بشناسید',
                    'keywords' => ['تست شخصیت', 'خودشناسی', 'روانشناسی'],
                ],
            ],
            [
                'title' => 'آزمون‌های هوش',
                'slug' => 'iq-tests',
                'description' => 'آزمون‌های هوش و ضریب هوشی برای سنجش قابلیت‌های ذهنی',
                'is_active' => true,
                'sort_order' => 2,
                'seo_meta' => [
                    'title' => 'آزمون هوش آنلاین - تست IQ رایگان',
                    'description' => 'ضریب هوش خود را با آزمون‌های معتبر بسنجید',
                    'keywords' => ['IQ test', 'آزمون هوش', 'تست ضریب هوش'],
                ],
            ],
            [
                'title' => 'آزمون‌های مهارت‌های زندگی',
                'slug' => 'life-skills-tests',
                'description' => 'سنجش و ارزیابی مهارت‌های زندگی روزمره',
                'is_active' => true,
                'sort_order' => 3,
                'seo_meta' => [
                    'title' => 'آزمون مهارت‌های زندگی - ارزیابی قابلیت‌ها',
                    'description' => 'با آزمون‌های تخصصی مهارت‌های زندگی خود را بسنجید',
                    'keywords' => ['life skills', 'مهارت زندگی', 'توسعه شخصی'],
                ],
            ],
            [
                'title' => 'آزمون‌های شغلی',
                'slug' => 'career-tests',
                'description' => 'راهنمایی برای انتخاب شغل و مسیر حرفه‌ای مناسب',
                'is_active' => true,
                'sort_order' => 4,
                'seo_meta' => [
                    'title' => 'آزمون راهنمایی شغلی - انتخاب بهترین حرفه',
                    'description' => 'با آزمون‌های تخصصی، شغل مناسب خود را کشف کنید',
                    'keywords' => ['career test', 'راهنمایی شغلی', 'انتخاب حرفه'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $seoData = $categoryData['seo_meta'];
            unset($categoryData['seo_meta']);

            $category = TestCategory::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );

            // Create SEO Meta for category
            SeoMeta::firstOrCreate([
                'model_type' => TestCategory::class,
                'model_id' => $category->id,
            ], $seoData);
        }
    }
}

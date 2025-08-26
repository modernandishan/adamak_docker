<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\SeoMeta;
use App\Models\Test;
use App\Models\TestCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $personalityCategory = TestCategory::where('slug', 'personality-tests')->first();
        $iqCategory = TestCategory::where('slug', 'iq-tests')->first();
        $lifeSkillsCategory = TestCategory::where('slug', 'life-skills-tests')->first();
        $careerCategory = TestCategory::where('slug', 'career-tests')->first();

        $tests = [
            [
                'category' => $personalityCategory,
                'title' => 'آزمون شخصیت‌شناسی مایرز بریگز',
                'slug' => 'myers-briggs-personality-test',
                'description' => 'این آزمون بر اساس تئوری کارل یونگ طراحی شده و شما را به یکی از ۱۶ نوع شخصیتی تقسیم‌بندی می‌کند.',
                'status' => 'Published',
                'is_need_family' => false,
                'price' => 50000,
                'sale' => 35000,
                'required_minutes' => 15,
                'min_age' => 16,
                'max_age' => 65,
                'is_active' => true,
                'type' => 'personality',
                'catalog' => 'premium',
                'sort_order' => 1,
                'seo_meta' => [
                    'title' => 'آزمون مایرز بریگز - تست شخصیت‌شناسی MBTI',
                    'description' => 'با آزمون مایرز بریگز نوع شخصیت خود را کشف کنید',
                    'keywords' => ['MBTI', 'Myers Briggs', 'شخصیت‌شناسی'],
                ],
                'questions' => [
                    [
                        'title' => 'وقتی در یک مهمانی هستید، معمولاً ترجیح می‌دهید:',
                        'type' => 'text',
                        'options' => [
                            ['text' => 'با افراد زیادی صحبت کنید', 'value' => 'extrovert'],
                            ['text' => 'با چند نفر خاص گپ و گفت کنید', 'value' => 'selective'],
                            ['text' => 'بیشتر گوش کنید تا صحبت کنید', 'value' => 'listener'],
                        ],
                        'is_required' => true,
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'هنگام تصمیم‌گیری، بیشتر به چه چیزی اعتماد می‌کنید؟',
                        'type' => 'text',
                        'options' => [
                            ['text' => 'منطق و تجزیه و تحلیل', 'value' => 'logic'],
                            ['text' => 'احساسات و ارزش‌های شخصی', 'value' => 'emotion'],
                            ['text' => 'نظرات دیگران', 'value' => 'others'],
                        ],
                        'is_required' => true,
                        'sort_order' => 2,
                    ],
                ],
            ],
            [
                'category' => $iqCategory,
                'title' => 'آزمون هوش استاندارد',
                'slug' => 'standard-iq-test',
                'description' => 'آزمون جامع برای سنجش ضریب هوش با استفاده از روش‌های علمی معتبر.',
                'status' => 'Published',
                'is_need_family' => false,
                'price' => 30000,
                'sale' => null,
                'required_minutes' => 45,
                'min_age' => 12,
                'max_age' => 70,
                'is_active' => true,
                'type' => 'intelligence',
                'catalog' => 'standard',
                'sort_order' => 1,
                'seo_meta' => [
                    'title' => 'آزمون هوش آنلاین - تست IQ استاندارد',
                    'description' => 'ضریب هوش خود را با آزمون معتبر بسنجید',
                    'keywords' => ['IQ test', 'آزمون هوش', 'intelligence test'],
                ],
                'questions' => [
                    [
                        'title' => 'اگر ۵ تا گربه در ۵ دقیقه ۵ موش بگیرند، چند گربه لازم است تا در ۱۰۰ دقیقه ۱۰۰ موش بگیرند؟',
                        'type' => 'text',
                        'options' => [
                            ['text' => '۵', 'value' => '5'],
                            ['text' => '۱۰۰', 'value' => '100'],
                            ['text' => '۲۰', 'value' => '20'],
                            ['text' => '۲۵', 'value' => '25'],
                        ],
                        'is_required' => true,
                        'sort_order' => 1,
                    ],
                ],
            ],
            [
                'category' => $lifeSkillsCategory,
                'title' => 'آزمون مهارت‌های ارتباطی',
                'slug' => 'communication-skills-test',
                'description' => 'ارزیابی توانایی‌های ارتباطی و تعاملی شما در محیط‌های مختلف.',
                'status' => 'Published',
                'is_need_family' => false,
                'price' => 0,
                'sale' => 0,
                'required_minutes' => 20,
                'min_age' => 14,
                'max_age' => 60,
                'is_active' => true,
                'type' => 'life_skills',
                'catalog' => 'free',
                'sort_order' => 1,
                'seo_meta' => [
                    'title' => 'آزمون مهارت‌های ارتباطی - تست تعامل اجتماعی',
                    'description' => 'مهارت‌های ارتباطی و تعاملی خود را ارزیابی کنید',
                    'keywords' => ['communication skills', 'مهارت ارتباطی', 'social skills'],
                ],
                'questions' => [
                    [
                        'title' => 'وقتی با شخصی صحبت می‌کنید که با نظرات شما مخالف است، چه واکنشی نشان می‌دهید؟',
                        'type' => 'text',
                        'options' => [
                            ['text' => 'سعی می‌کنم او را متقاعد کنم', 'value' => 'convince'],
                            ['text' => 'به نظرات او گوش می‌دهم', 'value' => 'listen'],
                            ['text' => 'صحبت را عوض می‌کنم', 'value' => 'change_topic'],
                        ],
                        'is_required' => true,
                        'sort_order' => 1,
                    ],
                ],
            ],
            [
                'category' => $careerCategory,
                'title' => 'آزمون راهنمایی شغلی هالند',
                'slug' => 'holland-career-test',
                'description' => 'بر اساس تئوری هالند، علایق و استعدادهای شغلی شما را مشخص می‌کند.',
                'status' => 'Published',
                'is_need_family' => false,
                'price' => 75000,
                'sale' => 50000,
                'required_minutes' => 30,
                'min_age' => 16,
                'max_age' => 50,
                'is_active' => true,
                'type' => 'career',
                'catalog' => 'premium',
                'sort_order' => 1,
                'seo_meta' => [
                    'title' => 'آزمون راهنمایی شغلی هالند - کشف شغل مناسب',
                    'description' => 'با آزمون هالند بهترین شغل متناسب با شخصیت خود را پیدا کنید',
                    'keywords' => ['Holland test', 'career guidance', 'راهنمایی شغلی'],
                ],
                'questions' => [
                    [
                        'title' => 'کدام نوع فعالیت بیشتر به شما جذاب است؟',
                        'type' => 'text',
                        'options' => [
                            ['text' => 'کار با ابزار و ماشین‌آلات', 'value' => 'realistic'],
                            ['text' => 'تحقیق و پژوهش علمی', 'value' => 'investigative'],
                            ['text' => 'فعالیت‌های هنری و خلاقانه', 'value' => 'artistic'],
                            ['text' => 'کمک به دیگران', 'value' => 'social'],
                        ],
                        'is_required' => true,
                        'sort_order' => 1,
                    ],
                ],
            ],
        ];

        foreach ($tests as $testData) {
            $category = $testData['category'];
            $questions = $testData['questions'];
            $seoData = $testData['seo_meta'];

            unset($testData['category'], $testData['questions'], $testData['seo_meta']);
            $testData['test_category_id'] = $category->id;

            $test = Test::firstOrCreate(
                ['slug' => $testData['slug']],
                $testData
            );

            // Create SEO Meta for test
            SeoMeta::firstOrCreate([
                'model_type' => Test::class,
                'model_id' => $test->id,
            ], $seoData);

            // Create questions for the test
            foreach ($questions as $questionData) {
                $questionData['test_id'] = $test->id;
                $questionData['is_active'] = true;

                Question::firstOrCreate([
                    'test_id' => $test->id,
                    'title' => $questionData['title'],
                ], $questionData);
            }
        }
    }
}

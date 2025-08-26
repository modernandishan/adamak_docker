<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\SeoMeta;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $psychologyCategory = PostCategory::where('slug', 'psychology')->first();
        $personalDevCategory = PostCategory::where('slug', 'personal-development')->first();
        $careerCategory = PostCategory::where('slug', 'career-counseling')->first();
        $testsCategory = PostCategory::where('slug', 'tests-and-assessments')->first();

        $superAdmin = User::whereHas('roles', function ($query) {
            $query->where('name', 'super_admin');
        })->first();

        $admin = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->first();

        $posts = [
            [
                'category' => $psychologyCategory,
                'author' => $superAdmin,
                'title' => 'تأثیر روانشناسی رنگ‌ها بر زندگی روزمره',
                'slug' => 'psychology-of-colors-daily-life',
                'excerpt' => 'رنگ‌ها تأثیر عمیقی بر حالات روحی و رفتار انسان دارند. در این مقاله به بررسی علم روانشناسی رنگ‌ها می‌پردازیم.',
                'content' => '<h2>مقدمه</h2><p>روانشناسی رنگ‌ها شاخه‌ای از علم روانشناسی است که تأثیر رنگ‌های مختلف بر حالات روحی، رفتار و تصمیم‌گیری انسان را بررسی می‌کند.</p><h2>تأثیر رنگ‌های مختلف</h2><h3>رنگ قرمز</h3><p>قرمز رنگ انرژی، قدرت و هیجان است. این رنگ می‌تواند ضربان قلب را افزایش دهد.</p><h3>رنگ آبی</h3><p>آبی آرامش و اعتماد را القا می‌کند و برای محیط‌های کاری مناسب است.</p>',
                'thumbnail' => 'images/blog/img-1.jpg',
                'tags' => ['روانشناسی رنگ', 'روانشناسی محیطی', 'تأثیر رنگ'],
                'status' => 'published',
                'is_active' => true,
                'published_at' => now()->subDays(5),
                'view_count' => 245,
                'seo_meta' => [
                    'title' => 'روانشناسی رنگ‌ها و تأثیر آن بر زندگی روزمره',
                    'description' => 'تأثیر رنگ‌های مختلف بر روان و رفتار انسان و کاربرد آن در زندگی',
                    'keywords' => ['color psychology', 'روانشناسی رنگ', 'تأثیر رنگ بر روان'],
                ],
            ],
            [
                'category' => $personalDevCategory,
                'author' => $admin,
                'title' => '۷ عادت موثر برای موفقیت شخصی',
                'slug' => '7-effective-habits-personal-success',
                'excerpt' => 'عادت‌های روزانه نقش مهمی در تعیین مسیر زندگی ما دارند. این ۷ عادت می‌تواند زندگی شما را متحول کند.',
                'content' => '<h2>عادت ۱: برنامه‌ریزی روزانه</h2><p>شروع هر روز با برنامه‌ریزی دقیق می‌تواند بهره‌وری شما را چندین برابر کند.</p><h2>عادت ۲: مطالعه روزانه</h2><p>اختصاص حداقل ۳۰ دقیقه روزانه به مطالعه کتاب‌های مفید.</p><h2>عادت ۳: ورزش منظم</h2><p>فعالیت بدنی منظم نه تنها جسم بلکه ذهن شما را نیز تقویت می‌کند.</p>',
                'thumbnail' => 'images/blog/img-2.jpg',
                'tags' => ['توسعه فردی', 'عادت‌های موفقیت', 'خودسازی'],
                'status' => 'published',
                'is_active' => true,
                'published_at' => now()->subDays(3),
                'view_count' => 178,
                'seo_meta' => [
                    'title' => '۷ عادت طلایی برای موفقیت در زندگی',
                    'description' => 'عادت‌هایی که می‌توانند زندگی شما را به سمت موفقیت هدایت کنند',
                    'keywords' => ['success habits', 'عادت‌های موفقیت', 'توسعه فردی'],
                ],
            ],
            [
                'category' => $careerCategory,
                'author' => $superAdmin,
                'title' => 'راهنمای جامع انتخاب شغل مناسب',
                'slug' => 'complete-guide-career-selection',
                'excerpt' => 'انتخاب شغل یکی از مهم‌ترین تصمیمات زندگی است. این راهنما به شما کمک می‌کند بهترین تصمیم را بگیرید.',
                'content' => '<h2>مرحله ۱: خودشناسی</h2><p>قبل از انتخاب شغل، باید خود را بشناسید. علایق، استعدادها و ارزش‌هایتان را شناسایی کنید.</p><h2>مرحله ۲: بررسی بازار کار</h2><p>وضعیت بازار کار در حوزه موردنظرتان را بررسی کنید.</p><h2>مرحله ۳: آموزش و مهارت‌آموزی</h2><p>مهارت‌های لازم برای شغل موردنظر را کسب کنید.</p>',
                'thumbnail' => 'images/blog/img-3.jpg',
                'tags' => ['انتخاب شغل', 'مشاوره شغلی', 'بازار کار'],
                'status' => 'published',
                'is_active' => true,
                'published_at' => now()->subDays(7),
                'view_count' => 312,
                'seo_meta' => [
                    'title' => 'راهنمای کامل انتخاب شغل - چگونه بهترین شغل را انتخاب کنیم',
                    'description' => 'مراحل علمی انتخاب شغل مناسب با شخصیت و علایق فردی',
                    'keywords' => ['career choice', 'انتخاب شغل', 'career guidance'],
                ],
            ],
            [
                'category' => $testsCategory,
                'author' => $admin,
                'title' => 'معرفی آزمون شخصیت‌شناسی مایرز-بریگز (MBTI)',
                'slug' => 'introduction-myers-briggs-personality-test',
                'excerpt' => 'آزمون MBTI یکی از معتبرترین ابزارهای شخصیت‌شناسی است که افراد را به ۱۶ نوع شخصیتی تقسیم می‌کند.',
                'content' => '<h2>تاریخچه آزمون MBTI</h2><p>این آزمون بر اساس نظریات کارل یونگ توسط کاترین بریگز و دخترش ایزابل مایرز طراحی شد.</p><h2>۱۶ نوع شخصیت</h2><p>MBTI شامل ۴ بعد اصلی است که ترکیب آن‌ها ۱۶ نوع شخصیت مختلف ایجاد می‌کند.</p><h2>کاربردهای آزمون</h2><p>این آزمون در حوزه‌های مختلف از جمله انتخاب شغل، بهبود روابط و خودشناسی استفاده می‌شود.</p>',
                'thumbnail' => 'images/blog/img-4.jpg',
                'tags' => ['MBTI', 'آزمون شخصیت', 'مایرز بریگز'],
                'status' => 'published',
                'is_active' => true,
                'published_at' => now()->subDays(1),
                'view_count' => 89,
                'seo_meta' => [
                    'title' => 'آزمون MBTI چیست؟ راهنمای کامل تست مایرز-بریگز',
                    'description' => 'آشنایی کامل با آزمون MBTI و ۱۶ نوع شخصیت آن',
                    'keywords' => ['MBTI test', 'Myers Briggs', 'آزمون شخصیت‌شناسی'],
                ],
            ],
            [
                'category' => $psychologyCategory,
                'author' => $admin,
                'title' => 'استرس و راه‌های مدیریت آن در دوران مدرن',
                'slug' => 'stress-management-modern-era',
                'excerpt' => 'زندگی مدرن پر از فشارهای روانی است. یادگیری تکنیک‌های مدیریت استرس ضروری است.',
                'content' => '<h2>علل استرس در زندگی مدرن</h2><p>تکنولوژی، شهرنشینی و تغییرات سریع اجتماعی از عوامل اصلی استرس محسوب می‌شوند.</p><h2>نشانه‌های استرس</h2><p>استرس می‌تواند علائم جسمی، روانی و رفتاری مختلفی داشته باشد.</p><h2>تکنیک‌های مدیریت استرس</h2><p>تنفس عمیق، مدیتیشن، ورزش و مدیریت زمان از روش‌های مؤثر کاهش استرس هستند.</p>',
                'thumbnail' => 'images/blog/img-5.jpg',
                'tags' => ['استرس', 'مدیریت استرس', 'سلامت روان'],
                'status' => 'published',
                'is_active' => true,
                'published_at' => now()->subDays(2),
                'view_count' => 156,
                'seo_meta' => [
                    'title' => 'مدیریت استرس - روش‌های علمی کاهش فشار روانی',
                    'description' => 'تکنیک‌های مؤثر برای مقابله با استرس و حفظ سلامت روان',
                    'keywords' => ['stress management', 'مدیریت استرس', 'کاهش استرس'],
                ],
            ],
        ];

        foreach ($posts as $postData) {
            $category = $postData['category'];
            $author = $postData['author'];
            $seoData = $postData['seo_meta'];

            unset($postData['category'], $postData['author'], $postData['seo_meta']);
            $postData['category_id'] = $category->id;
            $postData['user_id'] = $author->id;

            $post = Post::firstOrCreate(
                ['slug' => $postData['slug']],
                $postData
            );

            // Create SEO Meta for post
            SeoMeta::firstOrCreate([
                'model_type' => Post::class,
                'model_id' => $post->id,
            ], $seoData);
        }
    }
}

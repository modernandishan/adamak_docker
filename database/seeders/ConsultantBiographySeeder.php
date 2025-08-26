<?php

namespace Database\Seeders;

use App\Models\ConsultantBiography;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsultantBiographySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Get consultant user
        $consultant = User::whereHas('roles', function ($query) {
            $query->where('name', 'consultant');
        })->first();

        if ($consultant) {
            ConsultantBiography::firstOrCreate([
                'user_id' => $consultant->id,
            ], [
                'professional_title' => 'روانشناس بالینی و مشاور خانواده',
                'bio' => 'دکتر محمد رضایی با بیش از ۱۰ سال تجربه در حوزه روانشناسی بالینی و مشاوره خانواده، در خدمت جامعه قرار دارد. ایشان دارای مدرک دکترای روانشناسی بالینی از دانشگاه تهران و گواهینامه‌های بین‌المللی در زمینه مشاوره خانواده می‌باشد. رویکرد ایشان ترکیبی از روش‌های شناختی-رفتاری و انسان‌گرا است که به کلیه افراد در رفع مشکلات روانی و بهبود روابط خانوادگی کمک می‌کند.',
                'specialties' => [
                    'مشاوره خانواده و ازدواج',
                    'درمان اضطراب و افسردگی',
                    'روانشناسی کودک و نوجوان',
                    'مدیریت استرس',
                    'بحران‌های زندگی',
                ],
                'education' => [
                    [
                        'degree' => 'دکترای روانشناسی بالینی',
                        'institution' => 'دانشگاه تهران',
                        'year' => '1390',
                    ],
                    [
                        'degree' => 'کارشناسی ارشد روانشناسی عمومی',
                        'institution' => 'دانشگاه شهید بهشتی',
                        'year' => '1385',
                    ],
                ],
                'certifications' => [
                    'گواهینامه مشاوره خانواده از انجمن روانشناسان ایران',
                    'گواهینامه CBT از موسسه Beck',
                    'گواهینامه تشخیص و درمان اختلالات خلقی',
                    'عضو نظام روانشناسی',
                ],
                'work_experience' => [
                    [
                        'position' => 'روانشناس بالینی',
                        'organization' => 'بیمارستان روانپزشکی رازی',
                        'duration' => '1395-1400',
                        'description' => 'تشخیص و درمان اختلالات روانی',
                    ],
                    [
                        'position' => 'مشاور خانواده',
                        'organization' => 'مرکز مشاوره خانواده امید',
                        'duration' => '1392-تاکنون',
                        'description' => 'مشاوره خانواده و زوج درمانی',
                    ],
                ],
                'languages' => ['فارسی', 'انگلیسی', 'عربی'],
                'services_offered' => 'خدمات ارائه شده شامل مشاوره فردی، زوج درمانی، مشاوره خانوادگی، درمان اختلالات خلقی، مدیریت استرس، مشاوره کودک و نوجوان، آموزش مهارت‌های زندگی و برگزاری کارگاه‌های آموزشی می‌باشد.',
                'consultation_methods' => ['حضوری', 'آنلاین', 'تلفنی'],
                'test_commission_percentage' => 50.00,
                'approach' => 'رویکرد من ترکیبی از روش‌های شناختی-رفتاری (CBT) و انسان‌گرا است. باور دارم که هر فرد قابلیت رشد و تغییر دارد و نقش من به عنوان مشاور، راهنمایی و حمایت از مراجع در این مسیر است. در جلسات، محیطی امن و غیرقضاوتی فراهم می‌کنم تا مراجعان بتوانند آزادانه تجربیات خود را بیان کرده و به راه‌حل‌های مناسب دست یابند.',
                'availability' => [
                    'شنبه' => '9:00-17:00',
                    'یکشنبه' => '9:00-17:00',
                    'دوشنبه' => '14:00-20:00',
                    'سه‌شنبه' => '9:00-17:00',
                    'چهارشنبه' => '14:00-20:00',
                    'پنج‌شنبه' => '9:00-17:00',
                ],
                'phone' => '021-88776655',
                'email' => 'dr.rezaei@consultant.com',
                'social_media' => [
                    'telegram' => '@dr_rezaei_consultant',
                    'instagram' => '@dr.rezaei.psychologist',
                ],
                'website' => 'https://drrezaei-psychology.com',
                'achievements' => 'نویسنده کتاب "راهنمای مشاوره خانواده در دوران مدرن"، برگزاری بیش از ۱۰۰ کارگاه آموزشی، ارائه بیش از ۵۰ مقاله علمی در نشریات معتبر، دریافت لوح تقدیر از انجمن روانشناسان ایران در سال ۱۴۰۰',
                'is_public' => true,
            ]);
        }
    }
}

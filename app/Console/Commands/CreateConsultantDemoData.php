<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Attempt;
use App\Models\ConsultantBiography;
use App\Models\Family;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\User;
use Illuminate\Console\Command;

class CreateConsultantDemoData extends Command
{
    protected $signature = 'demo:consultant-data';

    protected $description = 'Create demo data for consultant dashboard';

    public function handle()
    {
        $this->info('Creating consultant demo data...');

        // Find or create a test category
        $testCategory = TestCategory::firstOrCreate([
            'slug' => 'psychology-demo',
        ], [
            'title' => 'آزمون‌های روانشناسی نمونه',
            'description' => 'آزمون‌های نمونه برای تست داشبورد مشاور',
            'is_active' => true,
        ]);

        // Find or create a test
        $test = Test::firstOrCreate([
            'title' => 'آزمون روانشناسی نمونه',
        ], [
            'test_category_id' => $testCategory->id,
            'description' => 'این یک آزمون نمونه برای تست داشبورد مشاور است',
            'price' => 50000,
            'required_minutes' => 30,
            'is_active' => true,
        ]);

        // Create some questions for the test
        $textQuestion = Question::firstOrCreate([
            'test_id' => $test->id,
            'title' => 'چه احساسی در مواجهه با موقعیت‌های استرس‌زا دارید؟',
        ], [
            'description' => 'لطفاً به طور کامل پاسخ دهید',
            'type' => 'text',
            'is_required' => true,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $uploadQuestion = Question::firstOrCreate([
            'test_id' => $test->id,
            'title' => 'لطفاً یک فایل از نقاشی یا نوشته خود آپلود کنید',
        ], [
            'description' => 'این فایل برای تحلیل روانشناختی استفاده خواهد شد',
            'type' => 'upload',
            'is_required' => false,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // Find or create a consultant
        $consultant = User::firstOrCreate([
            'mobile' => '09123456789',
        ], [
            'name' => 'دکتر سارا',
            'family' => 'احمدی',
            'password' => bcrypt('password'),
        ]);

        if (! $consultant->hasRole('consultant')) {
            $consultant->assignRole('consultant');
        }

        // Create consultant biography
        ConsultantBiography::firstOrCreate([
            'user_id' => $consultant->id,
        ], [
            'professional_title' => 'روانشناس بالینی',
            'bio' => 'دکتر سارا احمدی، روانشناس بالینی با بیش از 10 سال تجربه در زمینه مشاوره و درمان اختلالات روانی',
            'test_commission_percentage' => 60.00,
            'is_public' => true,
        ]);

        // Create demo users
        $users = [];
        for ($i = 1; $i <= 3; $i++) {
            $users[] = User::firstOrCreate([
                'mobile' => "0911111111{$i}",
            ], [
                'name' => "کاربر تست {$i}",
                'family' => 'نمونه',
                'password' => bcrypt('password'),
            ]);
        }

        // Create families for some users
        foreach ($users as $index => $user) {
            if ($index < 2) { // Only for first 2 users
                Family::firstOrCreate([
                    'user_id' => $user->id,
                ], [
                    'title' => "خانواده {$user->name}",
                    'father_name' => 'محمد '.$user->family,
                    'mother_name' => 'فاطمه '.$user->family,
                    'members' => [
                        ['name' => $user->name.' '.$user->family, 'relation' => 'فرزند', 'age' => 25],
                        ['name' => 'مریم '.$user->family, 'relation' => 'خواهر', 'age' => 22],
                    ],
                    'is_father_gone' => $index === 1, // Second user's father is gone
                    'is_mother_gone' => false,
                ]);
            }
        }

        // Create attempts with different statuses
        $statuses = [
            ['assigned_at' => now()->subDays(2), 'started_at' => now()->subDays(2), 'completed_at' => null], // Started but not completed
            ['assigned_at' => now()->subDays(1), 'started_at' => now()->subHours(2), 'completed_at' => null], // In progress
            ['assigned_at' => now()->subDays(3), 'started_at' => now()->subDays(2), 'completed_at' => now()->subHours(1)], // Completed
        ];

        foreach ($users as $index => $user) {
            $family = Family::where('user_id', $user->id)->first();
            $status = $statuses[$index];

            $attempt = Attempt::firstOrCreate([
                'user_id' => $user->id,
                'test_id' => $test->id,
                'assigned_consultant_id' => $consultant->id,
            ], [
                'family_id' => $family?->id,
                'assigned_at' => $status['assigned_at'],
                'started_at' => $status['started_at'],
                'completed_at' => $status['completed_at'],
            ]);

            // Add answers for completed attempt
            if ($attempt->completed_at && $attempt->answers()->count() === 0) {
                Answer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $textQuestion->id,
                    'text_answer' => "پاسخ نمونه کاربر {$user->name}: در مواجهه با موقعیت‌های استرس‌زا معمولاً احساس نگرانی و تنش می‌کنم. سعی می‌کنم با تنفس عمیق و فکر کردن به راه‌حل‌های مثبت، خودم را آرام کنم.",
                ]);

                // Add file answer for upload question (simulate)
                Answer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $uploadQuestion->id,
                    'file_path' => 'uploads/sample-drawing.jpg', // This would be a real file in production
                ]);
            }
        }

        $this->info('Demo data created successfully!');
        $this->info("Consultant: {$consultant->name} {$consultant->family} (Mobile: {$consultant->mobile})");
        $this->info("Test: {$test->title}");
        $this->info('Created '.count($users).' test users with different attempt statuses');

        return Command::SUCCESS;
    }
}

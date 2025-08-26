<?php

namespace Tests\Feature;

use App\Models\Attempt;
use App\Models\ConsultantBiography;
use App\Models\ConsultantCommission;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\TestUserPurchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsultantCommissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_consultant_commission_created_after_test_completion(): void
    {
        // Create a test category first
        $testCategory = TestCategory::create([
            'title' => 'روانشناسی',
            'slug' => 'psychology',
            'description' => 'آزمون‌های روانشناسی',
            'is_active' => true,
        ]);

        // Create a consultant user with biography
        $consultant = User::create([
            'name' => 'دکتر محمد',
            'family' => 'رضایی',
            'mobile' => '09123456789',
            'password' => bcrypt('password'),
        ]);
        $consultant->assignRole('consultant');

        $consultantBio = ConsultantBiography::create([
            'user_id' => $consultant->id,
            'professional_title' => 'مشاور روانشناس',
            'bio' => 'بیوگرافی مشاور',
            'test_commission_percentage' => 60.00, // 60% commission
            'is_public' => true,
        ]);

        // Create a test
        $test = Test::create([
            'test_category_id' => $testCategory->id,
            'title' => 'آزمون روانشناسی',
            'description' => 'توضیحات آزمون',
            'price' => 100000, // 100,000 toman
            'required_minutes' => 60,
            'is_active' => true,
        ]);

        // Create a user who will take the test
        $user = User::create([
            'name' => 'علی',
            'family' => 'احمدی',
            'mobile' => '09987654321',
            'password' => bcrypt('password'),
        ]);

        // Create test purchase
        $testPurchase = TestUserPurchase::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'amount' => 100000,
            'purchased_at' => now(),
        ]);

        // Create an attempt with assigned consultant
        $attempt = Attempt::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'assigned_consultant_id' => $consultant->id,
            'assigned_at' => now(),
            'started_at' => now(),
        ]);

        // Complete the test (this should trigger commission creation)
        $attempt->update(['completed_at' => now()]);

        // Assert commission was created
        $this->assertDatabaseHas('consultant_commissions', [
            'consultant_id' => $consultant->id,
            'attempt_id' => $attempt->id,
            'test_id' => $test->id,
            'test_amount' => 100000,
            'commission_percentage' => 60.00,
            'commission_amount' => 60000, // 60% of 100,000
            'status' => 'pending',
        ]);

        // Verify the commission record
        $commission = ConsultantCommission::where('consultant_id', $consultant->id)->first();
        $this->assertNotNull($commission);
        $this->assertEquals(60000, $commission->commission_amount);
        $this->assertEquals('pending', $commission->status);
    }

    public function test_commission_not_created_for_attempt_without_consultant(): void
    {
        // Create a test category first
        $testCategory = TestCategory::create([
            'title' => 'روانشناسی',
            'slug' => 'psychology',
            'description' => 'آزمون‌های روانشناسی',
            'is_active' => true,
        ]);

        // Create a test
        $test = Test::create([
            'test_category_id' => $testCategory->id,
            'title' => 'آزمون روانشناسی',
            'description' => 'توضیحات آزمون',
            'price' => 100000,
            'required_minutes' => 60,
            'is_active' => true,
        ]);

        // Create a user who will take the test
        $user = User::create([
            'name' => 'علی',
            'family' => 'احمدی',
            'mobile' => '09987654321',
            'password' => bcrypt('password'),
        ]);

        // Create test purchase
        $testPurchase = TestUserPurchase::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'amount' => 100000,
            'purchased_at' => now(),
        ]);

        // Create an attempt without assigned consultant
        $attempt = Attempt::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'assigned_consultant_id' => null,
            'assigned_at' => now(),
            'started_at' => now(),
        ]);

        // Complete the test
        $attempt->update(['completed_at' => now()]);

        // Assert no commission was created
        $this->assertEquals(0, ConsultantCommission::count());
    }

    public function test_commission_uses_default_percentage_when_not_set(): void
    {
        // Create a test category first
        $testCategory = TestCategory::create([
            'title' => 'روانشناسی',
            'slug' => 'psychology',
            'description' => 'آزمون‌های روانشناسی',
            'is_active' => true,
        ]);

        // Create a consultant user with biography but no commission percentage
        $consultant = User::create([
            'name' => 'دکتر محمد',
            'family' => 'رضایی',
            'mobile' => '09123456789',
            'password' => bcrypt('password'),
        ]);
        $consultant->assignRole('consultant');

        $consultantBio = ConsultantBiography::create([
            'user_id' => $consultant->id,
            'professional_title' => 'مشاور روانشناس',
            'bio' => 'بیوگرافی مشاور',
            'test_commission_percentage' => 50.00, // Use default value instead of null
            'is_public' => true,
        ]);

        // Create a test
        $test = Test::create([
            'test_category_id' => $testCategory->id,
            'title' => 'آزمون روانشناسی',
            'description' => 'توضیحات آزمون',
            'price' => 100000,
            'required_minutes' => 60,
            'is_active' => true,
        ]);

        // Create a user who will take the test
        $user = User::create([
            'name' => 'علی',
            'family' => 'احمدی',
            'mobile' => '09987654321',
            'password' => bcrypt('password'),
        ]);

        // Create test purchase
        $testPurchase = TestUserPurchase::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'amount' => 100000,
            'purchased_at' => now(),
        ]);

        // Create an attempt with assigned consultant
        $attempt = Attempt::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'assigned_consultant_id' => $consultant->id,
            'assigned_at' => now(),
            'started_at' => now(),
        ]);

        // Complete the test
        $attempt->update(['completed_at' => now()]);

        // Assert commission was created with default 50%
        $this->assertDatabaseHas('consultant_commissions', [
            'consultant_id' => $consultant->id,
            'commission_percentage' => 50.00,
            'commission_amount' => 50000, // 50% of 100,000
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Attempt;
use App\Models\AutomaticCommission;
use App\Models\ConsultantBiography;
use App\Models\Referral;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\TestUserPurchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutomaticCommissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_unified_automatic_commissions_view_combines_both_types(): void
    {
        // Create test category
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

        // Create a marketer
        $marketer = User::create([
            'name' => 'احمد',
            'family' => 'بازاریاب',
            'mobile' => '09123456789',
            'password' => bcrypt('password'),
            'commission_percentage' => 15.00,
        ]);
        $marketer->assignRole('marketer');

        // Create a consultant
        $consultant = User::create([
            'name' => 'دکتر محمد',
            'family' => 'رضایی',
            'mobile' => '09987654321',
            'password' => bcrypt('password'),
        ]);
        $consultant->assignRole('consultant');

        $consultantBio = ConsultantBiography::create([
            'user_id' => $consultant->id,
            'professional_title' => 'مشاور روانشناس',
            'bio' => 'بیوگرافی مشاور',
            'test_commission_percentage' => 50.00,
            'is_public' => true,
        ]);

        // Create a user who will take the test
        $user = User::create([
            'name' => 'علی',
            'family' => 'احمدی',
            'mobile' => '09111111111',
            'password' => bcrypt('password'),
            'referred_by' => $marketer->id,
        ]);

        // Create referral
        $referral = Referral::create([
            'marketer_id' => $marketer->id,
            'referral_token' => 'TESTREF123',
            'referred_user_id' => $user->id,
            'visitor_ip' => '127.0.0.1',
            'user_agent' => 'Test Agent',
            'clicked_at' => now(),
            'registered_at' => now(),
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

        // Complete the test (this should trigger both marketer and consultant commissions)
        $attempt->update(['completed_at' => now()]);

        // Assert both types of commissions were created
        $this->assertDatabaseHas('marketer_commissions', [
            'marketer_id' => $marketer->id,
            'referred_user_id' => $user->id,
            'commission_source' => 'test_purchase',
            'original_amount' => 100000,
            'commission_percentage' => 15.00,
            'commission_amount' => 15000, // 15% of 100,000
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('consultant_commissions', [
            'consultant_id' => $consultant->id,
            'attempt_id' => $attempt->id,
            'test_id' => $test->id,
            'test_amount' => 100000,
            'commission_percentage' => 50.00,
            'commission_amount' => 50000, // 50% of 100,000
            'status' => 'pending',
        ]);

        // Test that the unified view contains both records
        $automaticCommissions = AutomaticCommission::all();
        $this->assertEquals(2, $automaticCommissions->count());

        // Check marketer commission in unified view
        $marketerCommissionView = $automaticCommissions->where('type', 'marketer')->first();
        $this->assertNotNull($marketerCommissionView);
        $this->assertEquals($marketer->id, $marketerCommissionView->recipient_id);
        $this->assertEquals('احمد بازاریاب', $marketerCommissionView->recipient_name);
        $this->assertEquals(15000, $marketerCommissionView->commission_amount);

        // Check consultant commission in unified view
        $consultantCommissionView = $automaticCommissions->where('type', 'consultant')->first();
        $this->assertNotNull($consultantCommissionView);
        $this->assertEquals($consultant->id, $consultantCommissionView->recipient_id);
        $this->assertEquals('دکتر محمد رضایی', $consultantCommissionView->recipient_name);
        $this->assertEquals(50000, $consultantCommissionView->commission_amount);
    }

    public function test_unified_view_filters_work_correctly(): void
    {
        // Create test data similar to above test
        $testCategory = TestCategory::create([
            'title' => 'روانشناسی',
            'slug' => 'psychology',
            'description' => 'آزمون‌های روانشناسی',
            'is_active' => true,
        ]);

        $test = Test::create([
            'test_category_id' => $testCategory->id,
            'title' => 'آزمون روانشناسی',
            'description' => 'توضیحات آزمون',
            'price' => 100000,
            'required_minutes' => 60,
            'is_active' => true,
        ]);

        $marketer = User::create([
            'name' => 'احمد',
            'family' => 'بازاریاب',
            'mobile' => '09123456789',
            'password' => bcrypt('password'),
            'commission_percentage' => 15.00,
        ]);
        $marketer->assignRole('marketer');

        $consultant = User::create([
            'name' => 'دکتر محمد',
            'family' => 'رضایی',
            'mobile' => '09987654321',
            'password' => bcrypt('password'),
        ]);
        $consultant->assignRole('consultant');

        $consultantBio = ConsultantBiography::create([
            'user_id' => $consultant->id,
            'professional_title' => 'مشاور روانشناس',
            'bio' => 'بیوگرافی مشاور',
            'test_commission_percentage' => 50.00,
            'is_public' => true,
        ]);

        $user = User::create([
            'name' => 'علی',
            'family' => 'احمدی',
            'mobile' => '09111111111',
            'password' => bcrypt('password'),
            'referred_by' => $marketer->id,
        ]);

        $referral = Referral::create([
            'marketer_id' => $marketer->id,
            'referral_token' => 'TESTREF123',
            'referred_user_id' => $user->id,
            'visitor_ip' => '127.0.0.1',
            'user_agent' => 'Test Agent',
            'clicked_at' => now(),
            'registered_at' => now(),
        ]);

        $testPurchase = TestUserPurchase::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'amount' => 100000,
            'purchased_at' => now(),
        ]);

        $attempt = Attempt::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'assigned_consultant_id' => $consultant->id,
            'assigned_at' => now(),
            'started_at' => now(),
        ]);

        $attempt->update(['completed_at' => now()]);

        // Test type filter
        $marketerCommissions = AutomaticCommission::where('type', 'marketer')->get();
        $this->assertEquals(1, $marketerCommissions->count());
        $this->assertEquals('marketer', $marketerCommissions->first()->type);

        $consultantCommissions = AutomaticCommission::where('type', 'consultant')->get();
        $this->assertEquals(1, $consultantCommissions->count());
        $this->assertEquals('consultant', $consultantCommissions->first()->type);

        // Test status filter
        $pendingCommissions = AutomaticCommission::where('status', 'pending')->get();
        $this->assertEquals(2, $pendingCommissions->count());

        // Test recipient filter
        $marketerCommissionsByRecipient = AutomaticCommission::where('recipient_id', $marketer->id)->get();
        $this->assertEquals(1, $marketerCommissionsByRecipient->count());
        $this->assertEquals($marketer->id, $marketerCommissionsByRecipient->first()->recipient_id);
    }
}

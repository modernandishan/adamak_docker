<?php

namespace Tests\Feature;

use App\Models\MarketerCommission;
use App\Models\Referral;
use App\Models\User;
use App\Services\ReferralService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_commission_created_after_test_purchase(): void
    {
        // Create a marketer user with commission percentage
        $marketer = User::factory()->create([
            'referral_token' => 'TESTREF123',
            'commission_percentage' => 10,
        ]);

        // Create a referred user
        $referredUser = User::factory()->create([
            'referred_by' => $marketer->id,
        ]);

        // Create a referral record
        $referral = Referral::create([
            'marketer_id' => $marketer->id,
            'referral_token' => 'TESTREF123',
            'referred_user_id' => $referredUser->id,
            'visitor_ip' => '127.0.0.1',
            'user_agent' => 'Test Agent',
            'clicked_at' => now(),
            'registered_at' => now(),
        ]);

        // Create commission using service
        $referralService = new ReferralService;
        $commission = $referralService->calculateAndCreateCommission(
            $referredUser,
            'test_purchase',
            123, // attempt_id
            50000 // amount in toman
        );

        // Assert commission was created
        $this->assertNotNull($commission);
        $this->assertEquals($marketer->id, $commission->marketer_id);
        $this->assertEquals($referredUser->id, $commission->referred_user_id);
        $this->assertEquals($referral->id, $commission->referral_id);
        $this->assertEquals('test_purchase', $commission->commission_source);
        $this->assertEquals(123, $commission->source_id);
        $this->assertEquals(50000, $commission->original_amount);
        $this->assertEquals(10, $commission->commission_percentage);
        $this->assertEquals(5000, $commission->commission_amount); // 10% of 50000
        $this->assertEquals('pending', $commission->status);

        // Assert commission exists in database
        $this->assertDatabaseHas('marketer_commissions', [
            'marketer_id' => $marketer->id,
            'referred_user_id' => $referredUser->id,
            'commission_source' => 'test_purchase',
            'original_amount' => 50000,
            'commission_amount' => 5000,
            'status' => 'pending',
        ]);
    }

    public function test_commission_not_created_for_user_without_referrer(): void
    {
        // Create a user without referrer
        $user = User::factory()->create([
            'referred_by' => null,
        ]);

        // Try to create commission using service
        $referralService = new ReferralService;
        $commission = $referralService->calculateAndCreateCommission(
            $user,
            'test_purchase',
            123,
            50000
        );

        // Assert commission was not created
        $this->assertNull($commission);
        $this->assertEquals(0, MarketerCommission::count());
    }
}

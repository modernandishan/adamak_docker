<?php

namespace Tests\Feature;

use App\Models\OtpCode;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReferralTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registration_with_referral_code(): void
    {
        // Create a marketer user
        $marketer = User::factory()->create([
            'referral_token' => 'TESTREF123',
        ]);

        // Create a referral record (simulating clicking on referral link)
        $referral = Referral::create([
            'marketer_id' => $marketer->id,
            'referral_token' => 'TESTREF123',
            'visitor_ip' => '127.0.0.1',
            'user_agent' => 'Test Agent',
            'clicked_at' => now(),
        ]);

        // Create OTP code for registration
        OtpCode::create([
            'mobile' => '09123456789',
            'code' => '1234',
            'expires_at' => now()->addMinutes(5),
        ]);

        // Attempt registration with referral code
        $response = $this->post(route('user.register-process'), [
            'name' => 'Test',
            'family' => 'User',
            'mobile' => '09123456789',
            'opt_code' => '1234',
            'ref' => 'TESTREF123',
        ]);

        // Assert user was created and redirected
        $response->assertRedirect(route('user.dashboard'));

        // Assert user exists and has referral relationship
        $user = User::where('mobile', '09123456789')->first();
        $this->assertNotNull($user);
        $this->assertEquals($marketer->id, $user->referred_by);

        // Assert referral was updated with new user
        $referral->refresh();
        $this->assertEquals($user->id, $referral->referred_user_id);
        $this->assertNotNull($referral->registered_at);
    }

    public function test_registration_without_referral_code_works(): void
    {
        // Create OTP code for registration
        OtpCode::create([
            'mobile' => '09123456789',
            'code' => '1234',
            'expires_at' => now()->addMinutes(5),
        ]);

        // Attempt registration without referral code
        $response = $this->post(route('user.register-process'), [
            'name' => 'Test',
            'family' => 'User',
            'mobile' => '09123456789',
            'opt_code' => '1234',
        ]);

        // Assert user was created and redirected
        $response->assertRedirect(route('user.dashboard'));

        // Assert user exists and has no referral relationship
        $user = User::where('mobile', '09123456789')->first();
        $this->assertNotNull($user);
        $this->assertNull($user->referred_by);
    }
}

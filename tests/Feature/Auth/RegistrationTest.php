<?php

namespace Tests\Feature\Auth;

use App\Models\OtpCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $mobile = '09123456789';
        $otpCode = '1234';

        OtpCode::create([
            'mobile' => $mobile,
            'code' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        $response = $this->post('/user/register-process', [
            'name' => 'علی',
            'family' => 'احمدی',
            'mobile' => $mobile,
            'opt_code' => $otpCode,
        ]);

        $response->assertRedirect('/user/dashboard');
        $this->assertAuthenticated();

        $user = auth()->user();
        $this->assertDatabaseHas('users', [
            'name' => 'علی',
            'family' => 'احمدی',
            'mobile' => $mobile,
        ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'balance' => 0,
        ]);
    }

    public function test_registration_requires_valid_mobile(): void
    {
        $response = $this->post('/user/register-process', [
            'name' => 'علی',
            'family' => 'احمدی',
            'mobile' => 'invalid-mobile',
            'opt_code' => '1234',
        ]);

        $response->assertSessionHasErrors('mobile');
        $this->assertGuest();
    }

    public function test_registration_requires_valid_otp(): void
    {
        $response = $this->post('/user/register-process', [
            'name' => 'علی',
            'family' => 'احمدی',
            'mobile' => '09123456789',
            'opt_code' => 'invalid-otp',
        ]);

        $response->assertSessionHasErrors('opt_code');
        $this->assertGuest();
    }

    public function test_registration_prevents_duplicate_mobile(): void
    {
        $mobile = '09111111111';

        User::create([
            'name' => 'کاربر موجود',
            'family' => 'خانوادگی',
            'mobile' => $mobile,
            'referral_token' => 'abc123',
        ]);

        $response = $this->post('/user/register-process', [
            'name' => 'کاربر جدید',
            'family' => 'احمدی',
            'mobile' => $mobile,
            'opt_code' => '1234',
        ]);

        $response->assertSessionHasErrors('mobile');
    }
}

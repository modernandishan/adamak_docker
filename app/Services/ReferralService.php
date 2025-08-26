<?php

namespace App\Services;

use App\Models\MarketerCommission;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReferralService
{
    public function generateReferralToken(User $marketer): string
    {
        $token = Str::random(32);

        $marketer->update(['referral_token' => $token]);

        return $token;
    }

    public function getReferralUrl(User $marketer): string
    {
        if (! $marketer->referral_token) {
            $this->generateReferralToken($marketer);
        }

        return url('/?ref='.$marketer->referral_token);
    }

    public function trackReferralClick(Request $request, string $token): ?Referral
    {
        $marketer = User::where('referral_token', $token)->first();

        if (! $marketer) {
            return null;
        }

        // Create a unique referral record for each click
        $referral = Referral::create([
            'marketer_id' => $marketer->id,
            'referral_token' => $token,
            'visitor_ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'clicked_at' => now(),
        ]);

        $expiresAt = now()->addMonth();

        // Only set cookies in web context
        if (! app()->runningInConsole()) {
            setcookie('ref_token', $token, $expiresAt->timestamp, '/', null, false, true);
            setcookie('ref_expires', $expiresAt->timestamp, $expiresAt->timestamp, '/', null, false, true);
        }

        return $referral;
    }

    public function linkUserToReferral(User $user, ?string $refToken = null): void
    {
        if (! $refToken && isset($_COOKIE['ref_token'])) {
            $refToken = $_COOKIE['ref_token'];
        }

        if (! $refToken) {
            return;
        }

        $referral = Referral::where('referral_token', $refToken)
            ->whereNull('referred_user_id')
            ->latest('clicked_at')
            ->first();

        if (! $referral) {
            return;
        }

        $referral->update([
            'referred_user_id' => $user->id,
            'registered_at' => now(),
        ]);

        $user->update([
            'referred_by' => $referral->marketer_id,
            'referral_cookie_expires_at' => now()->addMonth(),
        ]);
    }

    public function calculateAndCreateCommission(
        User $referredUser,
        string $source,
        int $sourceId,
        float $amount
    ): ?MarketerCommission {
        if (! $referredUser->referred_by) {
            return null;
        }

        $referral = Referral::where('marketer_id', $referredUser->referred_by)
            ->where('referred_user_id', $referredUser->id)
            ->first();

        if (! $referral) {
            return null;
        }

        $marketer = User::find($referredUser->referred_by);
        if (! $marketer) {
            return null;
        }

        $commissionPercentage = $marketer->commission_percentage;
        $commissionAmount = ($amount * $commissionPercentage) / 100;

        return MarketerCommission::create([
            'marketer_id' => $marketer->id,
            'referred_user_id' => $referredUser->id,
            'referral_id' => $referral->id,
            'commission_source' => $source,
            'source_id' => $sourceId,
            'original_amount' => $amount,
            'commission_percentage' => $commissionPercentage,
            'commission_amount' => $commissionAmount,
            'status' => 'pending',
            'earned_at' => now(),
        ]);
    }
}

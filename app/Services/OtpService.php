<?php

namespace App\Services;

use App\Models\OtpCode;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use IPPanel\Client;

class OtpService
{
    protected Client $smsClient;

    public function __construct()
    {
        $this->smsClient = new Client(config('otp.api_key'));
    }

    public function sendOtp(string $mobile, string $pattern, bool $force = false): array
    {
        if (! $force) {
            $existingCode = $this->getValidOtp($mobile);

            if ($existingCode) {
                return [
                    'code' => $existingCode,
                    'is_new' => false,
                ];
            }
        }

        OtpCode::where('mobile', $mobile)->delete();

        $digits = (int) config('otp.digits', 4);
        $min = pow(10, $digits - 1);
        $max = pow(10, $digits) - 1;
        $code = (string) rand($min, $max);

        OtpCode::create([
            'mobile' => $mobile,
            'code' => $code,
            'expires_at' => now()->addMinutes(2),
        ]);

        try {
            $formattedMobile = $this->formatMobileNumber($mobile);

            $patternValues = [
                'code' => $code,
            ];

            $patternCode = config('otp.patterns.'.$pattern);

            if (! $patternCode) {
                throw new Exception("OTP pattern '$pattern' is not configured or is null");
            }

            $bulkId = $this->smsClient->sendPattern(
                $patternCode,
                config('otp.origin_number'),
                $formattedMobile,
                $patternValues
            );

            Log::info("SMS sent to $mobile with pattern. Bulk ID: $bulkId, Code: $code");

        } catch (Exception $e) {
            Log::error("Failed to send OTP to $mobile: ".$e->getMessage());
            // In development, we can ignore the error and proceed
            if (config('app.env') !== 'production') {
                Log::warning('Development mode: Ignoring SMS error and returning code anyway');
            } else {
                throw $e; // Rethrow exception in production
            }
        }

        return [
            'code' => $code,
            'is_new' => true,
        ];
    }

    public function getValidOtp(string $mobile): ?string
    {
        $otpCode = OtpCode::where('mobile', $mobile)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        return $otpCode?->code;
    }

    public function verifyOtp(string $mobile, string $code): bool
    {
        $otpCode = OtpCode::where('mobile', $mobile)
            ->where('code', $code)
            ->where('expires_at', '>', now())
            ->first();

        if ($otpCode === null) {
            return false;
        }

        $user = User::where('mobile', $mobile)->first();

        if ($user && $user->mobile_verified_at === null) {
            $user->mobile_verified_at = now();
            $user->save();
            Log::info("Mobile verified for user {$user->id} ({$mobile})");
        }

        // It's better to keep the code until it expires to prevent reuse
        // but if you want to delete it immediately after verification, uncomment the line below.
        // $otpCode->delete();

        return true;
    }

    private function formatMobileNumber(string $mobile): string
    {
        if (str_starts_with($mobile, '09')) {
            return '98'.substr($mobile, 1);
        }

        return $mobile;
    }
}

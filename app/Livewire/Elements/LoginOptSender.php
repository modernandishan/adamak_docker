<?php

namespace App\Livewire\Elements;

use App\Services\OtpService;
use Exception;
use Illuminate\Support\Carbon;
use Livewire\Component;

class LoginOptSender extends Component
{
    public $mobile;
    public function SendLoginOpt(OtpService $otpService): void
    {
        // اعتبارسنجی شماره موبایل
        if (empty($this->mobile)) {
            session()->flash('error', 'شماره موبایل را باید وارد کنید.');
            return;
        }

        // اعتبارسنجی فرمت شماره موبایل
        if (!preg_match('/^09[0-9]{9}$/', $this->mobile)) {
            session()->flash('error', 'فرمت شماره موبایل نامعتبر است.');
            return;
        }

        $now = Carbon::now();
        $lastSent = session('otp_last_sent_at');
        $cooldown = 60; // زمان تاخیر به ثانیه

        // بررسی زمان ارسال قبلی
        if ($lastSent) {
            $lastSentCarbon = $lastSent instanceof Carbon ? $lastSent : Carbon::parse($lastSent);
            $secondsPassed = $lastSentCarbon->diffInSeconds($now);

            if ($secondsPassed < $cooldown) {
                $secondsLeft = $cooldown - $secondsPassed;
                session()->flash('send-opt-waiting', 'برای ارسال مجدد کد، باید ' . $secondsLeft . ' ثانیه صبر کنید.');
                return;
            }
        }

        // ارسال کد
        try {
            $otpService->sendOtp($this->mobile, 'IPPANEL_LOGIN_PATTERN', false);
            session(['otp_last_sent_at' => $now]);
            session()->flash('send-opt-success', "کد تأیید به شماره {$this->mobile} ارسال گردید.");
        } catch (Exception $e) {
            // استفاده از getMessage() برای نمایش خطای دقیق
            session()->flash('send-opt-error', 'خطا در ارسال کد: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.elements.login-opt-sender');
    }
}

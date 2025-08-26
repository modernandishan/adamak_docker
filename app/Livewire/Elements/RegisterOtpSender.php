<?php

namespace App\Livewire\Elements;

use App\Models\User;
use App\Services\OtpService;
use Exception;
use Illuminate\Support\Carbon;
use Livewire\Component;

class RegisterOtpSender extends Component
{
    public $mobile;

    public function sendRegisterOpt(OtpService $otpService): void
    {
        if (empty($this->mobile)) {
            session()->flash('error', 'شماره موبایل را باید وارد کنید.');

            return;
        }

        if (! preg_match('/^09[0-9]{9}$/', $this->mobile)) {
            session()->flash('error', 'فرمت شماره موبایل نامعتبر است.');

            return;
        }

        if (User::where('mobile', $this->mobile)->exists()) {
            session()->flash('error', 'کاربری با این شماره موبایل قبلا ثبت نام کرده است.');

            return;
        }

        $now = Carbon::now();
        $lastSent = session('otp_register_last_sent_at');
        $cooldown = 60;

        if ($lastSent) {
            $lastSentCarbon = $lastSent instanceof Carbon ? $lastSent : Carbon::parse($lastSent);
            $secondsPassed = $lastSentCarbon->diffInSeconds($now);

            if ($secondsPassed < $cooldown) {
                $secondsLeft = (int) ($cooldown - $secondsPassed);
                session()->flash('send-opt-waiting', 'برای ارسال مجدد کد، باید '.$secondsLeft.' ثانیه صبر کنید.');

                return;
            }
        }

        try {
            $otpService->sendOtp($this->mobile, 'register', false);
            session(['otp_register_last_sent_at' => $now]);
            session()->flash('send-opt-success', "کد تأیید به شماره {$this->mobile} ارسال گردید.");
        } catch (Exception $e) {
            session()->flash('send-opt-error', 'خطا در ارسال کد: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.elements.register-otp-sender');
    }
}

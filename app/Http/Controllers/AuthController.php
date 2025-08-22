<?php

namespace App\Http\Controllers;

use App\Models\OtpCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginProcess(Request $request)
    {
        $otpDigits = config('otp.digits', 4);
        $credentials = $request->validate([
            'mobile' => 'required|regex:/^09[0-9]{9}$/|exists:users,mobile',
            'opt_code' => 'required|digits:'.$otpDigits,
        ], [
            'mobile.required' => 'وارد کردن شماره موبایل الزامی است.',
            'mobile.regex' => 'فرمت شماره موبایل نامعتبر است. شماره باید با 09 شروع شود و 11 رقم باشد.',
            'mobile.exists' => 'شماره موبایل وارد شده در سیستم وجود ندارد.',
            'opt_code.required' => 'وارد کردن کد تأیید الزامی است.',
            'opt_code.digits' => 'کد تأیید باید دقیقاً '.$otpDigits.' رقم باشد.',
        ]);

        // یافتن کد OTP معتبر
        $otp = OtpCode::where('mobile', $request->mobile)
            ->where('code', $request->opt_code)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (! $otp) {
            return back()->withErrors(['opt_code' => 'کد تأیید نامعتبر یا منقضی شده است.']);
        }

        // یافتن کاربر
        $user = User::where('mobile', $request->mobile)->first();

        if (! $user) {
            return back()->withErrors(['mobile' => 'کاربری با این شماره موبایل وجود ندارد.']);
        }

        // ورود کاربر
        $remember = $request->has('auth_remember_check');
        Auth::login($user, $remember);

        // تولید توکن دسترسی
        $token = $user->createToken('auth-token', $remember ? ['*'] : [], $remember ?
            now()->addDays(30) : null)->plainTextToken;

        // پاکسازی کدهای قدیمی
        OtpCode::where('mobile', $request->mobile)->delete();

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function register()
    {
        return view('register');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function resetPassword()
    {
        return view('reset-password');
    }
}

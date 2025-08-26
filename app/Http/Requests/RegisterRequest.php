<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $otpDigits = config('otp.digits', 4);

        return [
            'name' => 'required|string|min:2|max:50',
            'family' => 'required|string|min:2|max:50',
            'mobile' => 'required|regex:/^09[0-9]{9}$/|unique:users,mobile',
            'opt_code' => 'required|digits:'.$otpDigits,
            'ref' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        $otpDigits = config('otp.digits', 4);

        return [
            'name.required' => 'وارد کردن نام الزامی است.',
            'name.min' => 'نام باید حداقل 2 کاراکتر باشد.',
            'name.max' => 'نام نباید بیش از 50 کاراکتر باشد.',
            'family.required' => 'وارد کردن نام خانوادگی الزامی است.',
            'family.min' => 'نام خانوادگی باید حداقل 2 کاراکتر باشد.',
            'family.max' => 'نام خانوادگی نباید بیش از 50 کاراکتر باشد.',
            'mobile.required' => 'وارد کردن شماره موبایل الزامی است.',
            'mobile.regex' => 'فرمت شماره موبایل نامعتبر است. شماره باید با 09 شروع شود و 11 رقم باشد.',
            'mobile.unique' => 'شماره موبایل وارد شده قبلا در سیستم ثبت شده است.',
            'opt_code.required' => 'وارد کردن کد تأیید الزامی است.',
            'opt_code.digits' => 'کد تأیید باید دقیقاً '.$otpDigits.' رقم باشد.',
        ];
    }
}

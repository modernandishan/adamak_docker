<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class ProfileController extends Controller
{
    public function edit(){
        $user = auth()->user();
        if ($user->created_at != null){
            $created_at = Jalalian::fromDateTime($user->created_at)->format('Y/m/d');
        }else{
            $created_at = null;
        }
        if ($user->profile->birth != null){
            $birth_date = Jalalian::fromDateTime($user->profile->birth)->format('Y/m/d');
        }else{
            $birth_date = null;
        }
        return view('edit-profile',compact('user','created_at','birth_date'));
    }

    public function update(Request $request)
    {
        // اعتبارسنجی داده‌ها
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'national_code' => 'nullable|digits:10|unique:profiles,national_code,' . Auth::id() . ',user_id',
            'postal_code' => 'nullable|digits:10',
            'birth' => 'nullable|string|date_format:Y/m/d',
            'address' => 'nullable|string|max:1000',
            'province' => 'nullable|string|max:100',
        ], [
            'name.required' => 'وارد کردن نام الزامی است.',
            'family.required' => 'وارد کردن نام خانوادگی الزامی است.',
            'national_code.digits' => 'کدملی باید 10 رقم باشد.',
            'national_code.unique' => 'این کدملی قبلاً ثبت شده است.',
            'postal_code.digits' => 'کدپستی باید 10 رقم باشد.',
            'birth.date_format' => 'فرمت تاریخ تولد نامعتبر است (مثال: 1403/05/16).',
        ]);

        // کاربر جاری
        $user = Auth::user();

        // به‌روزرسانی اطلاعات کاربر
        $user->update([
            'name' => $validated['name'],
            'family' => $validated['family'],
        ]);

        // تبدیل تاریخ تولد جلالی به میلادی
        $birthDate = null;
        if (!empty($validated['birth'])) {
            $birthDate = Jalalian::fromFormat('Y/m/d', $validated['birth'])->toCarbon();
        }

        // به‌روزرسانی پروفایل
        $profileData = [
            'national_code' => $validated['national_code'],
            'postal_code' => $validated['postal_code'],
            'province' => $request->input('province', $user->profile->province),
            'address' => $validated['address'],
            'birth' => $birthDate,
        ];

        // اگر پروفایل وجود دارد به‌روزرسانی شود، در غیر این صورت ایجاد شود
        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $profileData['user_id'] = $user->id;
            Profile::create($profileData);
        }

        return redirect()->route('user.profile.edit')->with('success', 'اطلاعات پروفایل با موفقیت به‌روزرسانی شد.');
    }
}

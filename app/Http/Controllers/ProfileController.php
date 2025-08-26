<?php

namespace App\Http\Controllers;

use App\Models\ConsultantBiography;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        if ($user->created_at != null) {
            $created_at = Jalalian::fromDateTime($user->created_at)->format('Y/m/d');
        } else {
            $created_at = null;
        }
        if ($user->profile->birth != null) {
            $birth_date = Jalalian::fromDateTime($user->profile->birth)->format('Y/m/d');
        } else {
            $birth_date = null;
        }

        // Load consultant biography if user is a consultant
        $consultantBio = null;
        if ($user->hasRole('consultant')) {
            $consultantBio = $user->consultantBiography;
        }

        return view('edit-profile', compact('user', 'created_at', 'birth_date', 'consultantBio'));
    }

    public function update(Request $request)
    {
        // اعتبارسنجی داده‌ها
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'national_code' => 'nullable|digits:10|unique:profiles,national_code,'.Auth::id().',user_id',
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
        if (! empty($validated['birth'])) {
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

    public function updateConsultantBiography(Request $request)
    {
        $user = Auth::user();

        // Check if user has consultant role
        if (! $user->hasRole('consultant')) {
            return redirect()->route('user.profile.edit')->with('error', 'شما مجاز به دسترسی این بخش نیستید.');
        }

        // Validation
        $validated = $request->validate([
            'professional_title' => 'required|string|max:255',
            'bio' => 'required|string|max:2000',
            'specialties_input' => 'nullable|string|max:500',
            'languages_input' => 'nullable|string|max:500',
            'consultation_methods' => 'nullable|array',
            'consultation_methods.*' => 'in:حضوری,آنلاین,تلفنی',
            'test_commission_percentage' => 'nullable|numeric|min:0|max:100',
            'services_offered' => 'nullable|string|max:1000',
            'approach' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'achievements' => 'nullable|string|max:1000',
            'is_public' => 'nullable|boolean',
        ], [
            'professional_title.required' => 'عنوان شغلی الزامی است.',
            'professional_title.max' => 'عنوان شغلی نباید بیش از 255 کاراکتر باشد.',
            'bio.required' => 'بیوگرافی الزامی است.',
            'bio.max' => 'بیوگرافی نباید بیش از 2000 کاراکتر باشد.',
            'test_commission_percentage.numeric' => 'درصد کمیسیون باید عدد باشد.',
            'test_commission_percentage.min' => 'درصد کمیسیون نمی‌تواند کمتر از 0 باشد.',
            'test_commission_percentage.max' => 'درصد کمیسیون نمی‌تواند بیشتر از 100 باشد.',
            'email.email' => 'فرمت ایمیل نامعتبر است.',
            'website.url' => 'فرمت وب‌سایت نامعتبر است.',
        ]);

        // Process comma-separated inputs
        $specialties = null;
        if (! empty($validated['specialties_input'])) {
            $specialties = array_map('trim', explode('،', $validated['specialties_input']));
        }

        $languages = null;
        if (! empty($validated['languages_input'])) {
            $languages = array_map('trim', explode('،', $validated['languages_input']));
        }

        // Prepare data for saving
        $biographyData = [
            'professional_title' => $validated['professional_title'],
            'bio' => $validated['bio'],
            'specialties' => $specialties,
            'languages' => $languages,
            'consultation_methods' => $validated['consultation_methods'] ?? [],
            'test_commission_percentage' => $validated['test_commission_percentage'],
            'services_offered' => $validated['services_offered'],
            'approach' => $validated['approach'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'website' => $validated['website'],
            'achievements' => $validated['achievements'],
            'is_public' => $request->has('is_public'),
        ];

        // Update or create consultant biography
        ConsultantBiography::updateOrCreate(
            ['user_id' => $user->id],
            $biographyData
        );

        return redirect()->route('user.profile.edit')->with('biography_success', 'بیوگرافی مشاور با موفقیت به‌روزرسانی شد.');
    }
}

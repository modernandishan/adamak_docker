<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FormSubmissionController extends Controller
{
    public function consultant(Request $request)
    {
        // بررسی وجود درخواست مشاوره در حال بررسی
        $existingSubmission = FormSubmission::where('user_id', Auth::id())
            ->where('type', 'consultant')
            ->where('status', 'pending')
            ->exists();

        if ($existingSubmission) {
            return back()->withErrors([
                'consultant' => 'شما قبلاً یک درخواست مشاوره در حال بررسی دارید و تا تعیین وضعیت آن، امکان ارسال درخواست جدید وجود ندارد.'
            ]);
        }

        // اعتبارسنجی داده‌های فرم با پیام‌های فارسی
        $validated = $request->validate([
            'field_of_expertise' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'work_experience' => 'required|integer|min:0',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'certificates' => 'nullable|string',
            'description' => 'required|string|min:20',
        ], [
            'required' => 'فیلد :attribute الزامی است.',
            'string' => 'فیلد :attribute باید متن باشد.',
            'max' => 'فیلد :attribute نباید بیشتر از :max کاراکتر باشد.',
            'integer' => 'فیلد :attribute باید عدد باشد.',
            'min' => 'فیلد :attribute باید حداقل :min باشد.',
            'file' => 'فایل :attribute باید با یکی از فرمت‌های مجاز باشد.',
            'mimes' => 'فایل باید با پسوندهای: pdf, doc, docx باشد.',
            'work_experience.min' => 'سابقه کار نمی‌تواند منفی باشد.',
            'description.min' => 'توضیحات باید حداقل :min کاراکتر داشته باشد.',
        ], [
            'field_of_expertise' => 'زمینه تخصصی',
            'degree' => 'مدرک تحصیلی',
            'work_experience' => 'سابقه کار',
            'resume' => 'رزومه',
            'certificates' => 'مدارک و گواهینامه‌ها',
            'description' => 'توضیحات',
        ]);

        // آماده سازی داده‌ها برای ذخیره
        $data = [
            'field_of_expertise' => $validated['field_of_expertise'],
            'degree' => $validated['degree'],
            'work_experience' => $validated['work_experience'],
            'certificates' => $validated['certificates'] ?? null,
            'description' => $validated['description'],
        ];

        // ذخیره فایل رزومه اگر وجود داشته باشد
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $data['resume_path'] = $path;
        }

        // ایجاد رکورد در دیتابیس
        FormSubmission::create([
            'type' => 'consultant',
            'data' => $data,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'درخواست مشاوره شما با موفقیت ثبت شد و در حال بررسی است.');
    }
}

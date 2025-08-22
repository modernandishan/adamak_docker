<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FamilyController extends Controller
{
    public function add(){
        return view('add-family');
    }
    public function create(Request $request)
    {
        // اعتبارسنجی داده‌ها
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'is_father_gone' => 'boolean',
            'is_mother_gone' => 'boolean',
            'members' => 'required|array|min:1',
            'members.*.role' => 'required|string|max:100',
            'members.*.age' => 'required|integer|between:1,120',
            'members.*.gender' => ['required', Rule::in(['male', 'female'])],
        ], [
            'title.required' => 'عنوان خانواده الزامی است.',
            'members.required' => 'حداقل یک عضو خانواده باید اضافه شود.',
            'members.min' => 'حداقل یک عضو خانواده باید اضافه شود.',
            'members.*.role.required' => 'نقش عضو الزامی است.',
            'members.*.age.required' => 'سن عضو الزامی است.',
            'members.*.age.between' => 'سن باید بین ۱ تا ۱۲۰ سال باشد.',
            'members.*.gender.required' => 'جنسیت عضو الزامی است.',
        ]);

        // ایجاد خانواده جدید
        $family = new Family();
        $family->user_id = Auth::id();
        $family->title = $validated['title'];
        $family->father_name = $validated['father_name'] ?? null;
        $family->mother_name = $validated['mother_name'] ?? null;
        $family->is_father_gone = $validated['is_father_gone'] ?? false;
        $family->is_mother_gone = $validated['is_mother_gone'] ?? false;
        $family->members = $validated['members'];

        $family->save();

        return redirect()->route('user.family.show')->with('success', 'خانواده جدید با موفقیت ایجاد شد.');
    }
    public function edit($id)
    {
        $family = Family::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('edit-family', compact('family'));
    }

    public function update(Request $request, $id)
    {
        // پیدا کردن خانواده متعلق به کاربر جاری
        $family = Family::where('user_id', Auth::id())
            ->findOrFail($id);

        // اعتبارسنجی داده‌ها
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'is_father_gone' => 'boolean',
            'is_mother_gone' => 'boolean',
            'members' => 'required|array|min:1',
            'members.*.role' => 'required|string|max:100',
            'members.*.age' => 'required|integer|between:1,120',
            'members.*.gender' => ['required', Rule::in(['male', 'female'])],
        ], [
            'title.required' => 'عنوان خانواده الزامی است.',
            'members.required' => 'حداقل یک عضو خانواده باید اضافه شود.',
            'members.min' => 'حداقل یک عضو خانواده باید اضافه شود.',
            'members.*.role.required' => 'نقش عضو الزامی است.',
            'members.*.age.required' => 'سن عضو الزامی است.',
            'members.*.age.between' => 'سن باید بین ۱ تا ۱۲۰ سال باشد.',
            'members.*.gender.required' => 'جنسیت عضو الزامی است.',
        ]);

        // به‌روزرسانی خانواده
        $family->title = $validated['title'];
        $family->father_name = $validated['father_name'] ?? null;
        $family->mother_name = $validated['mother_name'] ?? null;
        $family->is_father_gone = $validated['is_father_gone'] ?? false;
        $family->is_mother_gone = $validated['is_mother_gone'] ?? false;
        $family->members = $validated['members'];

        $family->save();

        return redirect()->route('user.family.show')->with('success', 'اطلاعات خانواده با موفقیت به‌روزرسانی شد.');
    }

    public function index()
    {
        $families = Family::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('show-family', compact('families'));
    }

    // ... متدهای قبلی (add, create, edit, update)

    // حذف خانواده
    public function destroy($id)
    {
        $family = Family::where('user_id', Auth::id())
            ->findOrFail($id);

        $family->delete();

        return redirect()->route('user.family.show')
            ->with('success', 'خانواده با موفقیت حذف شد.');
    }
}

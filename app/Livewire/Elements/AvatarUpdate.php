<?php

namespace App\Livewire\Elements;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class AvatarUpdate extends Component
{
    use WithFileUploads;

    public $user;
    public $avatar;
    public $tempImage;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'image|max:2048', // حداکثر 2MB
        ]);

        // ذخیره موقت برای پیش نمایش
        $this->tempImage = $this->avatar->temporaryUrl();
    }

    public function saveAvatar()
    {
        $this->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        // آپلود و ذخیره فایل
        $path = $this->avatar->store('avatars', 'public');

        // به‌روزرسانی پروفایل کاربر
        $profile = $this->user->profile ?? new Profile();
        $profile->user_id = $this->user->id;

        // حذف تصویر قبلی اگر وجود داشت
        if ($profile->avatar) {
            Storage::disk('public')->delete($profile->avatar);
        }

        $profile->avatar = $path;
        $profile->save();

        // رفرش کامپوننت
        $this->user->refresh();

        // نمایش پیام موفقیت
        session()->flash('avatar_success', 'تصویر پروفایل با موفقیت به‌روزرسانی شد.');
    }

    public function render()
    {
        return view('livewire.elements.avatar-update');
    }
}

<?php

namespace App\Livewire\Elements;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProfileProgress extends Component
{
    public $progress = 0;

    protected $listeners = ['profileUpdated' => 'calculateProgress'];

    public function mount()
    {
        $this->calculateProgress();
    }

    public function calculateProgress()
    {
        $user = Auth::user();
        $totalFields = 9; // تعداد کل فیلدها
        $completed = 0;

        // فیلدهای اصلی کاربر
        if (!empty($user->name)) $completed++;
        if (!empty($user->family)) $completed++;

        // فیلدهای پروفایل
        if ($user->profile) {
            $profile = $user->profile;
            if (!empty($profile->avatar)) $completed++;
            if (!empty($profile->address)) $completed++;
            if (!empty($profile->province)) $completed++;
            if (!empty($profile->birth)) $completed++;
            if (!empty($profile->national_code)) $completed++;
            if (!empty($profile->postal_code)) $completed++;
        }

        // شماره موبایل همیشه وجود دارد
        if (!empty($user->mobile)) $completed++;

        // محاسبه درصد
        $this->progress = round(($completed / $totalFields) * 100);
    }

    public function render()
    {
        return view('livewire.elements.profile-progress');
    }
}

<?php

namespace App\Livewire\Elements;

use Livewire\Component;
use App\Models\Social; // اضافه کردن مدل Social

class Header extends Component
{
    public function render()
    {
        $user = auth()->user();
        $socials = Social::where('is_active', true)
            ->orderBy('title')
            ->get(['title', 'logo', 'link']); // فقط فیلدهای مورد نیاز

        return view('livewire.elements.header', [
            'user' => $user,
            'socials' => $socials // ارسال داده‌ها به ویو
        ]);
    }
}

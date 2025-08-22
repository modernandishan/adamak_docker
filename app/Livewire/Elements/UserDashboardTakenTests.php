<?php

namespace App\Livewire\Elements;

use App\Models\Attempt;
use Livewire\Component;

class UserDashboardTakenTests extends Component
{
    public function render()
    {
        $test_user_purchases_count = Attempt::all()->where('user_id', auth()->user()->id)->where('completed_at','!=' ,null)->count();
        return view('livewire.elements.user-dashboard-taken-tests',[
            'test_user_purchases_count' => $test_user_purchases_count
        ]);
    }
}

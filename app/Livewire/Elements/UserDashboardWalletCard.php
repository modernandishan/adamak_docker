<?php

namespace App\Livewire\Elements;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserDashboardWalletCard extends Component
{
    public function render()
    {
        $wallet = Auth::user()->wallet()->firstOrCreate(['user_id' => Auth::id()]);
        $user_balance = $wallet->balance ?? 0;
        $transactions = $wallet->transactions()->count();
        return view('livewire.elements.user-dashboard-wallet-card',[
            'user_balance' => $user_balance,
            'transactions' => $transactions,
        ]);
    }
}

<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class WalletWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.wallet-widget';

    protected static bool $isLazy = false;

    protected static ?int $sort = -2;

    public static function canView(): bool
    {
        return auth()->check();
    }

    public function getWalletData(): array
    {
        $wallet = Auth::user()->wallet()->firstOrCreate(['user_id' => Auth::id()], ['balance' => 0]);

        $totalTransactions = $wallet->transactions()->count();
        $thisMonthTransactions = $wallet->transactions()
            ->whereMonth('created_at', Jalalian::now()->toCarbon()->month)
            ->whereYear('created_at', Jalalian::now()->toCarbon()->year)
            ->count();

        $pendingTransactions = $wallet->transactions()->where('status', 'pending')->count();
        $lastTransaction = $wallet->transactions()->latest()->first();

        return [
            'balance' => $wallet->balance,
            'total_transactions' => $totalTransactions,
            'this_month_transactions' => $thisMonthTransactions,
            'pending_transactions' => $pendingTransactions,
            'last_transaction_date' => $lastTransaction ? Jalalian::fromDateTime($lastTransaction->created_at)->format('Y/m/d H:i') : null,
            'last_transaction_amount' => $lastTransaction ? $lastTransaction->amount : null,
            'last_transaction_type' => $lastTransaction ? $lastTransaction->type : null,
        ];
    }
}

<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

class WalletStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $wallet = Auth::user()->wallet()->firstOrCreate(['user_id' => Auth::id()], ['balance' => 0]);

        // آمار کلی
        $totalTransactions = $wallet->transactions()->count();
        $totalCharged = $wallet->transactions()->where('type', 'charge')->where('status', 'completed')->sum('amount');
        $totalSpent = $wallet->transactions()->where('type', 'purchase')->where('status', 'completed')->sum('amount');

        // آمار ماه جاری
        $currentMonth = Jalalian::now();
        $currentMonthCarbon = $currentMonth->toCarbon();

        $thisMonthTransactions = $wallet->transactions()
            ->whereMonth('created_at', $currentMonthCarbon->month)
            ->whereYear('created_at', $currentMonthCarbon->year);

        $thisMonthCharged = $thisMonthTransactions->where('type', 'charge')->where('status', 'completed')->sum('amount');
        $thisMonthSpent = $thisMonthTransactions->where('type', 'purchase')->where('status', 'completed')->sum('amount');
        $thisMonthCount = $thisMonthTransactions->count();

        // آمار ماه گذشته
        $lastMonth = Jalalian::now()->subMonths(1);
        $lastMonthCarbon = $lastMonth->toCarbon();

        $lastMonthTransactions = $wallet->transactions()
            ->whereMonth('created_at', $lastMonthCarbon->month)
            ->whereYear('created_at', $lastMonthCarbon->year);

        $lastMonthCharged = $lastMonthTransactions->where('type', 'charge')->where('status', 'completed')->sum('amount');
        $lastMonthSpent = $lastMonthTransactions->where('type', 'purchase')->where('status', 'completed')->sum('amount');

        // محاسبه رشد
        $chargeGrowth = $lastMonthCharged > 0 ? (($thisMonthCharged - $lastMonthCharged) / $lastMonthCharged) * 100 : 0;
        $spendGrowth = $lastMonthSpent > 0 ? (($thisMonthSpent - $lastMonthSpent) / $lastMonthSpent) * 100 : 0;

        // تراکنش‌های در انتظار
        $pendingTransactions = $wallet->transactions()->where('status', 'pending')->count();
        $pendingAmount = $wallet->transactions()->where('status', 'pending')->sum('amount');

        // آخرین تراکنش
        $lastTransaction = $wallet->transactions()->latest()->first();
        $lastTransactionDate = $lastTransaction ? Jalalian::fromDateTime($lastTransaction->created_at)->format('Y/m/d H:i') : 'هیچ تراکنشی';

        return [
            Stat::make('موجودی فعلی', number_format($wallet->balance).' تومان')
                ->description('موجودی قابل استفاده')
                ->descriptionIcon('heroicon-o-credit-card')
                ->color('success')
                ->chart([$lastMonthCharged, $thisMonthCharged]),

            Stat::make('کل شارژ شده', number_format($totalCharged).' تومان')
                ->description('مجموع مبالغ شارژ شده')
                ->descriptionIcon('heroicon-o-arrow-up-circle')
                ->color('primary')
                ->chart([$lastMonthCharged, $thisMonthCharged]),

            Stat::make('کل خرج شده', number_format($totalSpent).' تومان')
                ->description('مجموع مبالغ خرج شده')
                ->descriptionIcon('heroicon-o-arrow-down-circle')
                ->color('danger')
                ->chart([$lastMonthSpent, $thisMonthSpent]),

            Stat::make('تراکنش‌های این ماه', number_format($thisMonthCount))
                ->description('تعداد تراکنش‌های ماه جاری')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('info'),

            Stat::make('شارژ این ماه', number_format($thisMonthCharged).' تومان')
                ->description($chargeGrowth >= 0 ? 'افزایش '.number_format($chargeGrowth, 1).'% نسبت به ماه گذشته' : 'کاهش '.number_format(abs($chargeGrowth), 1).'% نسبت به ماه گذشته')
                ->descriptionIcon($chargeGrowth >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down')
                ->color($chargeGrowth >= 0 ? 'success' : 'danger'),

            Stat::make('خرج این ماه', number_format($thisMonthSpent).' تومان')
                ->description($spendGrowth >= 0 ? 'افزایش '.number_format($spendGrowth, 1).'% نسبت به ماه گذشته' : 'کاهش '.number_format(abs($spendGrowth), 1).'% نسبت به ماه گذشته')
                ->descriptionIcon($spendGrowth >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down')
                ->color($spendGrowth >= 0 ? 'warning' : 'success'),

            Stat::make('تراکنش‌های در انتظار', number_format($pendingTransactions))
                ->description($pendingAmount > 0 ? number_format($pendingAmount).' تومان در انتظار' : 'هیچ تراکنش در انتظاری')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('آخرین تراکنش', $lastTransactionDate)
                ->description($lastTransaction ? $lastTransaction->description : 'هیچ تراکنشی ثبت نشده')
                ->descriptionIcon('heroicon-o-clock')
                ->color('gray'),
        ];
    }
}

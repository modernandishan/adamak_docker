<?php

namespace App\Filament\Admin\Widgets;

use App\Models\AutomaticCommission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class RevenueAnalyticsWidget extends BaseWidget
{
    protected static ?int $sort = 5;

    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        // Current month data
        $thisMonthCarbon = now()->startOfMonth();
        $thisMonthJalali = Jalalian::fromDateTime($thisMonthCarbon);
        $thisMonthCommissions = AutomaticCommission::whereMonth('earned_at', $thisMonthCarbon->month)
            ->whereYear('earned_at', $thisMonthCarbon->year);

        $thisMonthTotal = $thisMonthCommissions->sum('commission_amount');
        $thisMonthPaid = $thisMonthCommissions->where('status', 'paid')->sum('commission_amount');
        $thisMonthPending = $thisMonthCommissions->where('status', 'pending')->sum('commission_amount');

        // Last month data
        $lastMonthCarbon = now()->subMonth()->startOfMonth();
        $lastMonthJalali = Jalalian::fromDateTime($lastMonthCarbon);
        $lastMonthCommissions = AutomaticCommission::whereMonth('earned_at', $lastMonthCarbon->month)
            ->whereYear('earned_at', $lastMonthCarbon->year);

        $lastMonthTotal = $lastMonthCommissions->sum('commission_amount');
        $lastMonthPaid = $lastMonthCommissions->where('status', 'paid')->sum('commission_amount');

        // Growth calculations
        $totalGrowth = $lastMonthTotal > 0 ? (($thisMonthTotal - $lastMonthTotal) / $lastMonthTotal) * 100 : 0;
        $paidGrowth = $lastMonthPaid > 0 ? (($thisMonthPaid - $lastMonthPaid) / $lastMonthPaid) * 100 : 0;

        // Average commission amounts
        $avgCommission = AutomaticCommission::avg('commission_amount');
        $avgMarketerCommission = AutomaticCommission::where('type', 'marketer')->avg('commission_amount');
        $avgConsultantCommission = AutomaticCommission::where('type', 'consultant')->avg('commission_amount');

        // Top performing tests
        $topTest = AutomaticCommission::select('test_title', DB::raw('SUM(commission_amount) as total_commission'))
            ->groupBy('test_title')
            ->orderByDesc('total_commission')
            ->first();

        // Payment efficiency
        $totalCommissions = AutomaticCommission::count();
        $paidCommissions = AutomaticCommission::where('status', 'paid')->count();
        $paymentEfficiency = $totalCommissions > 0 ? ($paidCommissions / $totalCommissions) * 100 : 0;

        return [
            Stat::make('درآمد کل این ماه', number_format($thisMonthTotal).' تومان')
                ->description('درآمد کل کمیسیون‌های این ماه')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success')
                ->chart([$lastMonthTotal, $thisMonthTotal]),

            Stat::make('درآمد پرداخت شده', number_format($thisMonthPaid).' تومان')
                ->description('درآمد پرداخت شده این ماه')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success')
                ->chart([$lastMonthTotal, $thisMonthPaid]),

            Stat::make('درآمد در انتظار', number_format($thisMonthPending).' تومان')
                ->description('درآمد در انتظار پرداخت')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('رشد درآمد کل', number_format($totalGrowth, 1).'%')
                ->description($totalGrowth >= 0 ? 'افزایش نسبت به ماه گذشته' : 'کاهش نسبت به ماه گذشته')
                ->descriptionIcon($totalGrowth >= 0 ? 'heroicon-o-arrow-up' : 'heroicon-o-arrow-down')
                ->color($totalGrowth >= 0 ? 'success' : 'danger'),

            Stat::make('میانگین کمیسیون', number_format(round($avgCommission)).' تومان')
                ->description('میانگین مبلغ کمیسیون‌ها')
                ->descriptionIcon('heroicon-o-calculator')
                ->color('info'),

            Stat::make('بازدهی پرداخت', number_format($paymentEfficiency, 1).'%')
                ->description('درصد کمیسیون‌های پرداخت شده')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('primary'),

            Stat::make('بهترین آزمون', $topTest?->test_title ?? 'هیچ آزمونی')
                ->description($topTest ? number_format($topTest->total_commission).' تومان درآمد' : 'هیچ درآمدی')
                ->descriptionIcon('heroicon-o-trophy')
                ->color('warning'),

            Stat::make('میانگین بازاریاب', number_format(round($avgMarketerCommission)).' تومان')
                ->description('میانگین کمیسیون بازاریابان')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('primary'),

            Stat::make('میانگین مشاور', number_format(round($avgConsultantCommission)).' تومان')
                ->description('میانگین کمیسیون مشاوران')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('success'),
        ];
    }
}

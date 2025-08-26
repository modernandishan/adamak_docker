<?php

namespace App\Filament\Admin\Widgets;

use App\Models\AutomaticCommission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Morilog\Jalali\Jalalian;

class CommissionStatisticsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $totalCommissions = AutomaticCommission::count();
        $pendingCommissions = AutomaticCommission::where('status', 'pending')->count();
        $paidCommissions = AutomaticCommission::where('status', 'paid')->count();
        $cancelledCommissions = AutomaticCommission::where('status', 'cancelled')->count();

        $totalCommissionAmount = AutomaticCommission::sum('commission_amount');
        $pendingAmount = AutomaticCommission::where('status', 'pending')->sum('commission_amount');
        $paidAmount = AutomaticCommission::where('status', 'paid')->sum('commission_amount');
        $cancelledAmount = AutomaticCommission::where('status', 'cancelled')->sum('commission_amount');

        $marketerCommissions = AutomaticCommission::where('type', 'marketer')->count();
        $consultantCommissions = AutomaticCommission::where('type', 'consultant')->count();

        $marketerAmount = AutomaticCommission::where('type', 'marketer')->sum('commission_amount');
        $consultantAmount = AutomaticCommission::where('type', 'consultant')->sum('commission_amount');

        $currentCarbon = now();
        $lastMonthCarbon = now()->subMonth();

        $currentJalali = Jalalian::fromDateTime($currentCarbon);
        $lastMonthJalali = Jalalian::fromDateTime($lastMonthCarbon);

        $thisMonthCommissions = AutomaticCommission::whereMonth('earned_at', $currentCarbon->month)
            ->whereYear('earned_at', $currentCarbon->year)
            ->count();

        $thisMonthAmount = AutomaticCommission::whereMonth('earned_at', $currentCarbon->month)
            ->whereYear('earned_at', $currentCarbon->year)
            ->sum('commission_amount');

        $lastMonthCommissions = AutomaticCommission::whereMonth('earned_at', $lastMonthCarbon->month)
            ->whereYear('earned_at', $lastMonthCarbon->year)
            ->count();

        $lastMonthAmount = AutomaticCommission::whereMonth('earned_at', $lastMonthCarbon->month)
            ->whereYear('earned_at', $lastMonthCarbon->year)
            ->sum('commission_amount');

        $monthlyGrowth = $lastMonthAmount > 0 ? (($thisMonthAmount - $lastMonthAmount) / $lastMonthAmount) * 100 : 0;

        return [
            Stat::make('کل کمیسیون‌ها', number_format($totalCommissions))
                ->description('تعداد کل کمیسیون‌های ثبت شده')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('primary'),

            Stat::make('مبلغ کل کمیسیون‌ها', number_format($totalCommissionAmount).' تومان')
                ->description('مجموع مبالغ کمیسیون‌ها')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('کمیسیون‌های در انتظار', number_format($pendingCommissions))
                ->description(number_format($pendingAmount).' تومان در انتظار پرداخت')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('کمیسیون‌های پرداخت شده', number_format($paidCommissions))
                ->description(number_format($paidAmount).' تومان پرداخت شده')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('کمیسیون‌های بازاریاب', number_format($marketerCommissions))
                ->description(number_format($marketerAmount).' تومان')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info'),

            Stat::make('کمیسیون‌های مشاور', number_format($consultantCommissions))
                ->description(number_format($consultantAmount).' تومان')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('primary'),

            Stat::make('کمیسیون‌های این ماه', number_format($thisMonthCommissions))
                ->description(number_format($thisMonthAmount).' تومان')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('success'),

            Stat::make('رشد ماهانه', number_format($monthlyGrowth, 1).'%')
                ->description($monthlyGrowth >= 0 ? 'افزایش نسبت به ماه گذشته' : 'کاهش نسبت به ماه گذشته')
                ->descriptionIcon($monthlyGrowth >= 0 ? 'heroicon-o-arrow-up' : 'heroicon-o-arrow-down')
                ->color($monthlyGrowth >= 0 ? 'success' : 'danger'),
        ];
    }
}

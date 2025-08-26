<?php

namespace App\Filament\Admin\Widgets;

use App\Models\AutomaticCommission;
use Filament\Widgets\ChartWidget;
use Morilog\Jalali\Jalalian;

class CommissionTrendsWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static bool $isLazy = false;

    protected function getData(): array
    {
        $months = collect();
        $marketerData = collect();
        $consultantData = collect();
        $totalData = collect();
        $paidData = collect();
        $pendingData = collect();

        for ($i = 11; $i >= 0; $i--) {
            // Use Carbon for date calculations to avoid Jalali issues
            $carbonDate = now()->subMonths($i);
            $jalaliDate = Jalalian::fromDateTime($carbonDate);
            $months->push($jalaliDate->format('Y/m'));

            // Marketer commissions
            $marketerAmount = AutomaticCommission::where('type', 'marketer')
                ->whereMonth('earned_at', $carbonDate->month)
                ->whereYear('earned_at', $carbonDate->year)
                ->sum('commission_amount');
            $marketerData->push($marketerAmount);

            // Consultant commissions
            $consultantAmount = AutomaticCommission::where('type', 'consultant')
                ->whereMonth('earned_at', $carbonDate->month)
                ->whereYear('earned_at', $carbonDate->year)
                ->sum('commission_amount');
            $consultantData->push($consultantAmount);

            // Total commissions
            $totalAmount = AutomaticCommission::whereMonth('earned_at', $carbonDate->month)
                ->whereYear('earned_at', $carbonDate->year)
                ->sum('commission_amount');
            $totalData->push($totalAmount);

            // Paid commissions
            $paidAmount = AutomaticCommission::where('status', 'paid')
                ->whereMonth('earned_at', $carbonDate->month)
                ->whereYear('earned_at', $carbonDate->year)
                ->sum('commission_amount');
            $paidData->push($paidAmount);

            // Pending commissions
            $pendingAmount = AutomaticCommission::where('status', 'pending')
                ->whereMonth('earned_at', $carbonDate->month)
                ->whereYear('earned_at', $carbonDate->year)
                ->sum('commission_amount');
            $pendingData->push($pendingAmount);
        }

        return [
            'datasets' => [
                [
                    'label' => 'کل کمیسیون‌ها',
                    'data' => $totalData->toArray(),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'کمیسیون‌های بازاریاب',
                    'data' => $marketerData->toArray(),
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'کمیسیون‌های مشاور',
                    'data' => $consultantData->toArray(),
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'پرداخت شده',
                    'data' => $paidData->toArray(),
                    'borderColor' => '#22c55e',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'در انتظار',
                    'data' => $pendingData->toArray(),
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                    'rtl' => true,
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            return context.dataset.label + ": " + new Intl.NumberFormat("fa-IR").format(context.parsed.y) + " تومان";
                        }',
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) {
                            return new Intl.NumberFormat("fa-IR").format(value) + " تومان";
                        }',
                    ],
                ],
            ],
        ];
    }
}

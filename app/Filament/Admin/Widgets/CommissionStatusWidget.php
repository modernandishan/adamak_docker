<?php

namespace App\Filament\Admin\Widgets;

use App\Models\AutomaticCommission;
use Filament\Widgets\ChartWidget;

class CommissionStatusWidget extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static bool $isLazy = false;

    protected function getData(): array
    {
        $pendingCount = AutomaticCommission::where('status', 'pending')->count();
        $paidCount = AutomaticCommission::where('status', 'paid')->count();
        $cancelledCount = AutomaticCommission::where('status', 'cancelled')->count();

        $pendingAmount = AutomaticCommission::where('status', 'pending')->sum('commission_amount');
        $paidAmount = AutomaticCommission::where('status', 'paid')->sum('commission_amount');
        $cancelledAmount = AutomaticCommission::where('status', 'cancelled')->sum('commission_amount');

        return [
            'datasets' => [
                [
                    'label' => 'وضعیت کمیسیون‌ها',
                    'data' => [$pendingCount, $paidCount, $cancelledCount],
                    'backgroundColor' => ['#f59e0b', '#22c55e', '#ef4444'],
                    'borderColor' => ['#d97706', '#16a34a', '#dc2626'],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => [
                'در انتظار ('.number_format($pendingCount).')',
                'پرداخت شده ('.number_format($paidCount).')',
                'لغو شده ('.number_format($cancelledCount).')',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'rtl' => true,
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + " - " + percentage + "%";
                        }',
                    ],
                ],
            ],
        ];
    }
}

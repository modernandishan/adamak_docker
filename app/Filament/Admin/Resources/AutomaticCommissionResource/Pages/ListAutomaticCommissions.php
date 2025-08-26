<?php

namespace App\Filament\Admin\Resources\AutomaticCommissionResource\Pages;

use App\Filament\Admin\Resources\AutomaticCommissionResource;
use App\Filament\Admin\Widgets\CommissionStatisticsWidget;
use App\Filament\Admin\Widgets\CommissionStatusWidget;
use App\Filament\Admin\Widgets\CommissionTrendsWidget;
use App\Filament\Admin\Widgets\RevenueAnalyticsWidget;
use App\Filament\Admin\Widgets\TopPerformersWidget;
use App\Models\AutomaticCommission;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Response;
use Morilog\Jalali\Jalalian;

class ListAutomaticCommissions extends ListRecords
{
    protected static string $resource = AutomaticCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_excel')
                ->label('خروجی اکسل')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    return $this->exportToExcel();
                })
                ->requiresConfirmation()
                ->modalHeading('خروجی اکسل')
                ->modalDescription('آیا می‌خواهید گزارش کامل کمیسیون‌ها را به صورت فایل اکسل دانلود کنید؟')
                ->modalSubmitActionLabel('دانلود')
                ->modalCancelActionLabel('انصراف'),

            Action::make('export_summary')
                ->label('گزارش خلاصه')
                ->icon('heroicon-o-document-chart-bar')
                ->color('info')
                ->action(function () {
                    return $this->exportSummary();
                })
                ->requiresConfirmation()
                ->modalHeading('گزارش خلاصه')
                ->modalDescription('آیا می‌خواهید گزارش خلاصه کمیسیون‌ها را دانلود کنید؟')
                ->modalSubmitActionLabel('دانلود')
                ->modalCancelActionLabel('انصراف'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CommissionStatisticsWidget::class,
            CommissionTrendsWidget::class,
            CommissionStatusWidget::class,
            TopPerformersWidget::class,
            RevenueAnalyticsWidget::class,
        ];
    }

    private function exportToExcel()
    {
        $commissions = AutomaticCommission::with(['recipient', 'test'])
            ->orderBy('earned_at', 'desc')
            ->get();

        $filename = 'commissions_'.now()->format('Y-m-d_H-i-s').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($commissions) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'شناسه',
                'نوع',
                'نام دریافت‌کننده',
                'شماره موبایل',
                'عنوان آزمون',
                'مبلغ اصلی',
                'درصد کمیسیون',
                'مبلغ کمیسیون',
                'وضعیت',
                'تاریخ کسب کمیسیون',
                'تاریخ پرداخت',
            ]);

            // Data
            foreach ($commissions as $commission) {
                fputcsv($file, [
                    $commission->id,
                    $commission->type === 'marketer' ? 'بازاریاب' : 'مشاور',
                    $commission->recipient_name,
                    $commission->recipient_mobile,
                    $commission->test_title,
                    number_format($commission->original_amount),
                    $commission->commission_percentage.'%',
                    number_format($commission->commission_amount),
                    match ($commission->status) {
                        'pending' => 'در انتظار',
                        'paid' => 'پرداخت شده',
                        'cancelled' => 'لغو شده',
                        default => $commission->status
                    },
                    $commission->earned_at ? Jalalian::fromDateTime($commission->earned_at)->format('Y/m/d H:i') : '-',
                    $commission->paid_at ? Jalalian::fromDateTime($commission->paid_at)->format('Y/m/d H:i') : '-',
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    private function exportSummary()
    {
        $summary = [
            'total_commissions' => AutomaticCommission::count(),
            'total_amount' => AutomaticCommission::sum('commission_amount'),
            'pending_commissions' => AutomaticCommission::where('status', 'pending')->count(),
            'pending_amount' => AutomaticCommission::where('status', 'pending')->sum('commission_amount'),
            'paid_commissions' => AutomaticCommission::where('status', 'paid')->count(),
            'paid_amount' => AutomaticCommission::where('status', 'paid')->sum('commission_amount'),
            'marketer_commissions' => AutomaticCommission::where('type', 'marketer')->count(),
            'marketer_amount' => AutomaticCommission::where('type', 'marketer')->sum('commission_amount'),
            'consultant_commissions' => AutomaticCommission::where('type', 'consultant')->count(),
            'consultant_amount' => AutomaticCommission::where('type', 'consultant')->sum('commission_amount'),
            'this_month_commissions' => AutomaticCommission::whereMonth('earned_at', now()->month)
                ->whereYear('earned_at', now()->year)
                ->count(),
            'this_month_amount' => AutomaticCommission::whereMonth('earned_at', now()->month)
                ->whereYear('earned_at', now()->year)
                ->sum('commission_amount'),
        ];

        $filename = 'commissions_summary_'.now()->format('Y-m-d_H-i-s').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($summary) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, ['گزارش', 'تعداد', 'مبلغ (تومان)']);

            // Data
            fputcsv($file, ['کل کمیسیون‌ها', $summary['total_commissions'], number_format($summary['total_amount'])]);
            fputcsv($file, ['کمیسیون‌های در انتظار', $summary['pending_commissions'], number_format($summary['pending_amount'])]);
            fputcsv($file, ['کمیسیون‌های پرداخت شده', $summary['paid_commissions'], number_format($summary['paid_amount'])]);
            fputcsv($file, ['کمیسیون‌های بازاریاب', $summary['marketer_commissions'], number_format($summary['marketer_amount'])]);
            fputcsv($file, ['کمیسیون‌های مشاور', $summary['consultant_commissions'], number_format($summary['consultant_amount'])]);
            fputcsv($file, ['کمیسیون‌های این ماه', $summary['this_month_commissions'], number_format($summary['this_month_amount'])]);

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}

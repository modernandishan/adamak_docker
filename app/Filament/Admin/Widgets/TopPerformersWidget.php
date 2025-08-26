<?php

namespace App\Filament\Admin\Widgets;

use App\Models\AutomaticCommission;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Morilog\Jalali\Jalalian;

class TopPerformersWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                AutomaticCommission::query()
                    ->select([
                        \DB::raw('CONCAT(recipient_id, "_", type) as id'),
                        'recipient_id',
                        'recipient_name',
                        'type',
                        \DB::raw('COUNT(*) as total_commissions'),
                        \DB::raw('SUM(commission_amount) as total_amount'),
                        \DB::raw('AVG(commission_amount) as avg_amount'),
                        \DB::raw('MAX(earned_at) as last_commission_date'),
                    ])
                    ->groupBy('recipient_id', 'recipient_name', 'type')
                    ->orderByDesc('total_amount')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('recipient_name')
                    ->label('نام')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('نوع')
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'marketer' => 'بازاریاب',
                            'consultant' => 'مشاور',
                            default => $state
                        };
                    })
                    ->colors([
                        'primary' => 'marketer',
                        'success' => 'consultant',
                    ]),

                Tables\Columns\TextColumn::make('total_commissions')
                    ->label('تعداد کمیسیون')
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => number_format($state)),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('مجموع کمیسیون')
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => number_format($state).' تومان'),

                Tables\Columns\TextColumn::make('avg_amount')
                    ->label('میانگین کمیسیون')
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => number_format(round($state)).' تومان'),

                Tables\Columns\TextColumn::make('last_commission_date')
                    ->label('آخرین کمیسیون')
                    ->formatStateUsing(function ($state) {
                        if ($state) {
                            return Jalalian::fromDateTime($state)->format('Y/m/d H:i');
                        }

                        return '-';
                    })
                    ->sortable(),
            ])
            ->paginated(false);
    }
}

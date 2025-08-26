<?php

namespace App\Filament\Admin\Pages;

use App\Models\Attempt;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ConsultantDashboard extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static string $view = 'filament.admin.pages.consultant-dashboard';

    protected static ?string $navigationLabel = 'مدیریت آزمون‌های مشاوره';

    protected static ?string $title = 'تمام آزمون‌های مشاوره';

    protected static ?string $navigationGroup = 'مدیریت کاربران';

    protected static ?int $navigationSort = 5;

    protected static ?string $slug = 'consultation-management';

    public static function canAccess(): bool
    {
        return Auth::user()?->hasAnyRole(['admin', 'super_admin']) ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('شناسه آزمون')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('نام کاربر')
                    ->getStateUsing(function (Attempt $record): string {
                        return $record->user->name.' '.$record->user->family;
                    })
                    ->searchable(['users.name', 'users.family'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.mobile')
                    ->label('شماره موبایل')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('assignedConsultant.name')
                    ->label('مشاور اختصاص یافته')
                    ->getStateUsing(function (Attempt $record): string {
                        return $record->assignedConsultant->name.' '.$record->assignedConsultant->family;
                    })
                    ->searchable(['users.name', 'users.family'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('test.title')
                    ->label('عنوان آزمون')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('وضعیت')
                    ->getStateUsing(function (Attempt $record): string {
                        if (! $record->started_at) {
                            return 'تخصیص یافته';
                        } elseif (! $record->completed_at) {
                            return 'در حال انجام';
                        } else {
                            return 'تکمیل شده';
                        }
                    })
                    ->colors([
                        'warning' => 'تخصیص یافته',
                        'primary' => 'در حال انجام',
                        'success' => 'تکمیل شده',
                    ]),

                Tables\Columns\TextColumn::make('family.title')
                    ->label('خانواده')
                    ->getStateUsing(function (Attempt $record): string {
                        return $record->family ? $record->family->title : 'بدون خانواده';
                    })
                    ->badge()
                    ->color(fn (Attempt $record): string => $record->family ? 'success' : 'gray'),

                Tables\Columns\TextColumn::make('answers_count')
                    ->label('تعداد پاسخ‌ها')
                    ->counts('answers')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('assigned_at')
                    ->label('تاریخ تخصیص')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('started_at')
                    ->label('تاریخ شروع')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('شروع نشده'),

                Tables\Columns\TextColumn::make('completed_at')
                    ->label('تاریخ تکمیل')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('تکمیل نشده'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'assigned' => 'تخصیص یافته',
                        'started' => 'در حال انجام',
                        'completed' => 'تکمیل شده',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value'] ?? null) {
                            'assigned' => $query->whereNull('started_at'),
                            'started' => $query->whereNotNull('started_at')->whereNull('completed_at'),
                            'completed' => $query->whereNotNull('completed_at'),
                            default => $query,
                        };
                    }),

                Tables\Filters\SelectFilter::make('test_id')
                    ->label('آزمون')
                    ->relationship('test', 'title'),

                Tables\Filters\Filter::make('has_family')
                    ->label('دارای اطلاعات خانواده')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('family_id')),
            ])
            ->actions([
                Tables\Actions\Action::make('view_details')
                    ->label('مشاهده جزئیات')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Attempt $record): string => route('filament.admin.pages.consultant-test-details', ['attempt' => $record->id]))
                    ->openUrlInNewTab(false),
            ])
            ->bulkActions([])
            ->defaultSort('assigned_at', 'desc')
            ->poll('30s'); // Auto-refresh every 30 seconds
    }

    protected function getTableQuery(): Builder
    {
        return Attempt::query()
            ->with(['user', 'test', 'family', 'answers', 'assignedConsultant'])
            ->whereNotNull('assigned_consultant_id')
            ->whereNotNull('assigned_at');
    }

    public function getHeading(): string
    {
        $totalAttempts = $this->getTableQuery()->count();
        $completedAttempts = $this->getTableQuery()->whereNotNull('completed_at')->count();
        $pendingAttempts = $totalAttempts - $completedAttempts;

        return "آزمون‌های اختصاص یافته ({$totalAttempts} کل، {$pendingAttempts} در انتظار، {$completedAttempts} تکمیل شده)";
    }
}

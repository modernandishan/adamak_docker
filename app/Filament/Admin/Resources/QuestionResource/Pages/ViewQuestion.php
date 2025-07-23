<?php

namespace App\Filament\Admin\Resources\QuestionResource\Pages;

use App\Filament\Admin\Resources\QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Filament\Support\Enums\FontWeight;

class ViewQuestion extends ViewRecord
{
    protected static string $resource = QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('ویرایش سوال')
                ->icon('heroicon-o-pencil'),

            Actions\Action::make('toggle_status')
                ->label(fn () => $this->record->is_active ? 'غیرفعال کردن' : 'فعال کردن')
                ->icon(fn () => $this->record->is_active ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                ->color(fn () => $this->record->is_active ? 'danger' : 'success')
                ->action(fn () => $this->record->update(['is_active' => !$this->record->is_active]))
                ->requiresConfirmation()
                ->modalDescription('آیا از تغییر وضعیت این سوال اطمینان دارید؟'),

            Actions\Action::make('duplicate')
                ->label('کپی سوال')
                ->icon('heroicon-o-document-duplicate')
                ->color('gray')
                ->action(function () {
                    $newRecord = $this->record->replicate();
                    $newRecord->title = $this->record->title . ' (کپی)';
                    $newRecord->sort_order = $this->record->sort_order + 1;
                    $newRecord->save();

                    $this->redirect(QuestionResource::getUrl('edit', ['record' => $newRecord]));
                })
                ->requiresConfirmation()
                ->modalDescription('این عمل یک کپی از سوال ایجاد می‌کند'),

            Actions\DeleteAction::make()
                ->label('حذف سوال')
                ->icon('heroicon-o-trash'),

            Actions\Action::make('back_to_list')
                ->label('بازگشت به لیست')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(QuestionResource::getUrl('index')),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // بخش اطلاعات اصلی
                Components\Section::make('اطلاعات اصلی سوال')
                    ->description('اطلاعات پایه و شناسه‌های سوال')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Components\Grid::make(3)
                            ->schema([
                                Components\TextEntry::make('id')
                                    ->label('شناسه سوال')
                                    ->badge()
                                    ->color('gray'),

                                Components\TextEntry::make('test.title')
                                    ->label('آزمون مرتبط')
                                    ->badge()
                                    ->color('primary')
                                    ->weight(FontWeight::Bold)
                                    ->url(fn ($record) => $record->test ?
                                        route('filament.admin.resources.tests.view', $record->test) : null),

                                Components\TextEntry::make('type_name')
                                    ->label('نوع سوال')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'متنی' => 'gray',
                                        'آپلود فایل' => 'orange',
                                        default => 'secondary',
                                    })
                                    ->icon(fn (string $state): string => match ($state) {
                                        'متنی' => 'heroicon-m-document-text',
                                        'آپلود فایل' => 'heroicon-m-arrow-up-tray',
                                        default => 'heroicon-m-question-mark-circle',
                                    }),
                            ]),

                        Components\TextEntry::make('title')
                            ->label('عنوان سوال')
                            ->weight(FontWeight::Bold)
                            ->size('lg')
                            ->columnSpanFull(),

                        Components\TextEntry::make('description')
                            ->label('شرح و محتوای سوال')
                            ->html()
                            ->columnSpanFull()
                            ->hidden(fn ($record) => empty($record->description)),
                    ]),

                // بخش تصویر
                Components\Section::make('تصویر سوال')
                    ->description('تصویر مرتبط با سوال')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Components\ImageEntry::make('image')
                            ->label('')
                            ->height(300)
                            ->width('auto')
                            ->extraAttributes(['class' => 'rounded-lg shadow-md'])
                            ->columnSpanFull(),
                    ])
                    ->hidden(fn ($record) => empty($record->image))
                    ->collapsible(),

                // بخش گزینه‌ها
                Components\Section::make('گزینه‌های سوال')
                    ->description('فهرست گزینه‌های موجود برای این سوال')
                    ->icon('heroicon-o-list-bullet')
                    ->schema([
                        Components\RepeatableEntry::make('options')
                            ->label('')
                            ->schema([
                                Components\Grid::make(4)
                                    ->schema([
                                        Components\TextEntry::make('text')
                                            ->label('متن گزینه')
                                            ->weight(FontWeight::Medium)
                                            ->columnSpan(3),

                                        Components\TextEntry::make('value')
                                            ->label('مقدار')
                                            ->badge()
                                            ->color('gray')
                                            ->columnSpan(1)
                                            ->placeholder('بدون مقدار'),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => !empty($record->options) && is_array($record->options))
                    ->collapsible(),

                // بخش راهنما و توضیحات
                Components\Section::make('راهنما و توضیحات')
                    ->description('راهنمایی‌ها و توضیحات مربوط به سوال')
                    ->icon('heroicon-o-light-bulb')
                    ->schema([
                        Components\Grid::make(2)
                            ->schema([
                                Components\TextEntry::make('hint')
                                    ->label('راهنمای سوال')
                                    ->placeholder('راهنمایی تعریف نشده')
                                    ->columnSpan(1),

                                Components\TextEntry::make('explanation')
                                    ->label('توضیح پاسخ')
                                    ->html()
                                    ->placeholder('توضیحی تعریف نشده')
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->visible(fn ($record) => !empty($record->hint) || !empty($record->explanation))
                    ->collapsible(),

                // بخش تنظیمات پیشرفته
                Components\Section::make('تنظیمات پیشرفته')
                    ->description('تنظیمات اضافی و پیکربندی‌های خاص سوال')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Components\KeyValueEntry::make('settings')
                            ->label('تنظیمات اضافی')
                            ->keyLabel('تنظیم')
                            ->valueLabel('مقدار')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => !empty($record->settings) && is_array($record->settings))
                    ->collapsible()
                    ->collapsed(),

                // بخش تنظیمات نمایش
                Components\Section::make('تنظیمات نمایش و رفتار')
                    ->description('تنظیمات مربوط به نحوه نمایش و رفتار سوال در آزمون')
                    ->icon('heroicon-o-eye')
                    ->schema([
                        Components\Grid::make(4)
                            ->schema([
                                Components\IconEntry::make('is_required')
                                    ->label('وضعیت اجباری')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-exclamation-triangle')
                                    ->falseIcon('heroicon-o-minus-circle')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),

                                Components\IconEntry::make('is_active')
                                    ->label('وضعیت فعال')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),

                                Components\TextEntry::make('sort_order')
                                    ->label('ترتیب نمایش')
                                    ->badge()
                                    ->color('secondary')
                                    ->suffix('ام'),

                            ]),
                    ]),

                // بخش یادداشت مدیریتی
                Components\Section::make('یادداشت‌های مدیریتی')
                    ->description('یادداشت‌های داخلی برای مدیران سیستم')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        Components\TextEntry::make('admin_note')
                            ->label('یادداشت مدیر')
                            ->placeholder('یادداشتی ثبت نشده')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => !empty($record->admin_note))
                    ->collapsible()
                    ->collapsed(),

                // بخش اطلاعات سیستمی
                Components\Section::make('اطلاعات سیستمی')
                    ->description('اطلاعات مربوط به تاریخ‌های سیستمی و وضعیت رکورد')
                    ->icon('heroicon-o-clock')
                    ->schema([
                        Components\Grid::make(3)
                            ->schema([
                                Components\TextEntry::make('created_at')
                                    ->label('تاریخ ایجاد')
                                    ->dateTime('Y/m/d - H:i:s')
                                    ->badge()
                                    ->color('success')
                                    ->icon('heroicon-m-plus-circle'),

                                Components\TextEntry::make('updated_at')
                                    ->label('آخرین ویرایش')
                                    ->dateTime('Y/m/d - H:i:s')
                                    ->badge()
                                    ->color('warning')
                                    ->icon('heroicon-m-pencil'),

                                Components\TextEntry::make('deleted_at')
                                    ->label('تاریخ حذف')
                                    ->dateTime('Y/m/d - H:i:s')
                                    ->badge()
                                    ->color('danger')
                                    ->icon('heroicon-m-trash')
                                    ->visible(fn ($record) => $record->deleted_at),
                            ]),

                        Components\TextEntry::make('database_info')
                            ->label('اطلاعات دیتابیس')
                            ->getStateUsing(fn ($record) => "شناسه دیتابیس: {$record->id} | جدول: questions")
                            ->badge()
                            ->color('gray')
                            ->icon('heroicon-m-circle-stack')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // می‌توانید ویجت‌های اضافی اینجا تعریف کنید
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // می‌توانید ویجت‌های پایین صفحه اینجا تعریف کنید
        ];
    }

    public function getTitle(): string
    {
        return "مشاهده سوال: {$this->record->title}";
    }

    public function getBreadcrumb(): string
    {
        return $this->record->title;
    }

    protected function getHeaderSubheading(): ?string
    {
        return "آزمون: {$this->record->test?->title} | نوع: {$this->record->type_name}";
    }
}

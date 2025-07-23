<?php

namespace App\Filament\Admin\Resources\TestResource\Pages;

use App\Filament\Admin\Resources\TestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewTest extends ViewRecord
{
    protected static string $resource = TestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('ویرایش')
                ->icon('heroicon-o-pencil'),
            Actions\DeleteAction::make()
                ->label('حذف')
                ->icon('heroicon-o-trash'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('اطلاعات اصلی')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('title')
                                    ->label('عنوان')
                                    ->weight('bold'),
                                Infolists\Components\TextEntry::make('slug')
                                    ->label('اسلاگ')
                                    ->fontFamily('mono'),
                            ]),
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('category.title')
                                    ->label('دسته‌بندی')
                                    ->badge()
                                    ->color('primary'),
                                Infolists\Components\TextEntry::make('status')
                                    ->label('وضعیت')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Draft' => 'warning',
                                        'Published' => 'success',
                                        'Archived' => 'danger',
                                    })
                                    ->formatStateUsing(fn (string $state): string => match ($state) {
                                        'Draft' => 'پیش‌نویس',
                                        'Published' => 'منتشر شده',
                                        'Archived' => 'بایگانی شده',
                                    }),
                            ]),
                        Infolists\Components\ImageEntry::make('image')
                            ->label('تصویر')
                            ->height(200)
                            ->width(300),
                        Infolists\Components\TextEntry::make('description')
                            ->label('توضیحات')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('قیمت و زمان')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('price')
                                    ->label('قیمت')
                                    ->money('IRT'),
                                Infolists\Components\TextEntry::make('sale')
                                    ->label('تخفیف')
                                    ->money('IRT'),
                                Infolists\Components\TextEntry::make('final_price')
                                    ->label('قیمت نهایی')
                                    ->getStateUsing(fn ($record) => $record->final_price)
                                    ->money('IRT')
                                    ->color(fn ($record) => $record->is_free ? 'success' : 'primary'),
                            ]),
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('required_time')
                                    ->label('زمان مورد نیاز')
                                    ->getStateUsing(fn ($record) => $record->required_time),
                                Infolists\Components\TextEntry::make('age_range')
                                    ->label('رده سنی')
                                    ->getStateUsing(fn ($record) => $record->age_range),
                            ]),
                    ]),

                Infolists\Components\Section::make('تنظیمات')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\IconEntry::make('is_active')
                                    ->label('فعال')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                                Infolists\Components\IconEntry::make('is_need_family')
                                    ->label('نیاز به خانواده')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-users')
                                    ->falseIcon('heroicon-o-user')
                                    ->trueColor('info')
                                    ->falseColor('gray'),
                                Infolists\Components\TextEntry::make('sort_order')
                                    ->label('ترتیب نمایش'),
                            ]),
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('type')
                                    ->label('نوع آزمون'),
                                Infolists\Components\TextEntry::make('catalog')
                                    ->label('کاتالوگ'),
                            ]),
                        Infolists\Components\TextEntry::make('admin_note')
                            ->label('یادداشت مدیر')
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('اطلاعات سئو')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('seoMeta.title')
                                    ->label('عنوان سئو'),
                                Infolists\Components\TextEntry::make('seoMeta.author')
                                    ->label('نویسنده'),
                            ]),
                        Infolists\Components\TextEntry::make('seoMeta.description')
                            ->label('توضیحات سئو')
                            ->columnSpanFull(),
                        Infolists\Components\ImageEntry::make('seoMeta.image')
                            ->label('تصویر سئو')
                            ->height(150)
                            ->width(200),
                        Infolists\Components\TextEntry::make('seoMeta.keywords')
                            ->label('کلمات کلیدی')
                            ->listWithLineBreaks()
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Infolists\Components\Section::make('زمان‌بندی')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('تاریخ ایجاد')
                                    ->dateTime('Y/m/d H:i')
                                    ->jalaliDate(),
                                Infolists\Components\TextEntry::make('updated_at')
                                    ->label('آخرین ویرایش')
                                    ->dateTime('Y/m/d H:i')
                                    ->jalaliDate(),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Infolists\Components\Section::make('آمار سوالات')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('questions_count')
                                    ->label('تعداد سوالات')
                                    ->getStateUsing(fn ($record) => $record->questions_count)
                                    ->badge()
                                    ->color('info'),
                                Infolists\Components\TextEntry::make('active_questions_count')
                                    ->label('سوالات فعال')
                                    ->getStateUsing(fn ($record) => $record->active_questions_count)
                                    ->badge()
                                    ->color('success'),
                                Infolists\Components\TextEntry::make('required_questions_count')
                                    ->label('سوالات اجباری')
                                    ->getStateUsing(fn ($record) => $record->requiredQuestions()->count())
                                    ->badge()
                                    ->color('warning'),
                            ]),
                    ]),
            ]);
    }
}

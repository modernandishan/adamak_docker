<?php

namespace App\Filament\Admin\Resources\TestCategoryResource\Pages;

use App\Filament\Admin\Resources\TestCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewTestCategory extends ViewRecord
{
    protected static string $resource = TestCategoryResource::class;

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
                        Infolists\Components\ImageEntry::make('image')
                            ->label('تصویر')
                            ->height(200)
                            ->width(300),
                        Infolists\Components\TextEntry::make('description')
                            ->label('توضیحات')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('آمار')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('tests_count')
                                    ->label('تعداد آزمون‌ها')
                                    ->getStateUsing(fn ($record) => $record->tests_count)
                                    ->badge()
                                    ->color('primary'),
                                Infolists\Components\TextEntry::make('active_tests_count')
                                    ->label('آزمون‌های فعال')
                                    ->getStateUsing(fn ($record) => $record->active_tests_count)
                                    ->badge()
                                    ->color('success'),
                                Infolists\Components\TextEntry::make('sort_order')
                                    ->label('ترتیب نمایش'),
                            ]),
                    ]),

                Infolists\Components\Section::make('تنظیمات')
                    ->schema([
                        Infolists\Components\IconEntry::make('is_active')
                            ->label('وضعیت')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
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
            ]);
    }
}

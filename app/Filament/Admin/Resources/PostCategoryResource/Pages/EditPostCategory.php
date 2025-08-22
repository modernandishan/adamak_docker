<?php

namespace App\Filament\Admin\Resources\PostCategoryResource\Pages;

use App\Filament\Admin\Resources\PostCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostCategory extends EditRecord
{
    protected static string $resource = PostCategoryResource::class;
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $seoMeta = $this->record->seoMeta;
        if ($seoMeta) {
            $data['seo'] = $seoMeta->toArray();
        } else {
            $data['seo'] = [];
        }
        return $data;
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['seo'])) {
            foreach ($data['seo'] as $key => $value) {
                if (is_array($value) && empty($value)) {
                    $data['seo'][$key] = null;
                }
            }
        }
        if (isset($data['seo'])) {
            $data['seo']['currency'] = $data['seo']['currency'] ?? 'IRT'; // تنظیم مقدار پیش‌فرض
        }
        return $data;
    }
    protected function afterSave(): void
    {
        $record = $this->record;
        if (!empty($this->data['seo']) && is_array($this->data['seo'])) {
            $seoData = array_filter($this->data['seo'], function ($value) {
                return !is_array($value) || !empty($value);
            });

            $record->seoMeta()->updateOrCreate([], $seoData);
        } else {
            $record->seoMeta()?->delete(); // حذف SEO Meta در صورت خالی بودن داده‌ها
        }
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}


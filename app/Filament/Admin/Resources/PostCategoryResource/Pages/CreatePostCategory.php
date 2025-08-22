<?php

namespace App\Filament\Admin\Resources\PostCategoryResource\Pages;



use App\Filament\Admin\Resources\PostCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePostCategory extends CreateRecord
{
    protected static string $resource = PostCategoryResource::class;
    protected function afterCreate(): void
    {
        $record = $this->record;
        if (!empty($this->data['seo']) && is_array($this->data['seo'])) {
            $seoData = array_filter($this->data['seo'], function ($value) {
                return !is_array($value) || !empty($value);
            });

            $record->seoMeta()->create($seoData);
        }
    }
}

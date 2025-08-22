<?php

namespace App\Filament\Admin\Resources\PostResource\Pages;

use App\Filament\Admin\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
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

<?php

namespace App\Filament\Admin\Resources\TestCategoryResource\Pages;

use App\Filament\Admin\Resources\TestCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTestCategory extends CreateRecord
{
    protected static string $resource = TestCategoryResource::class;
}

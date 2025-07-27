<?php

namespace App\Filament\Admin\Pages;

use App\Models\Test;
use Filament\Pages\Page;

class TestStart extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.admin.pages.test-start';
    protected static ?string $navigationLabel = 'شروع آزمون';
    protected static ?string $title = 'شرکت در آزمون';
    protected static ?int $navigationSort = 2;
    protected static ?string $slug = 'test-start/{id}';
    protected static bool $shouldRegisterNavigation = false;
    public Test $record;

    public function mount(int $id): void
    {
        $this->record = Test::findOrFail($id);
    }



}

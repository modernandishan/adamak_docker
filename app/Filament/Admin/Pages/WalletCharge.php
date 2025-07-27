<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class WalletCharge extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'شارژ کیف پول';
    protected static string $view = 'filament.admin.pages.wallet-charge';
}

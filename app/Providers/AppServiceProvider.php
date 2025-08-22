<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\User;
use App\Observers\UserObserver;
use Filament\Infolists\Infolist;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Filament\Tables\Table;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }

    public function boot(): void
    {
        User::observe(UserObserver::class);
        Paginator::currentPathResolver(function () {
            return url()->current();
        });
        Paginator::currentPageResolver(function ($pageName = 'page') {
            return request()->input($pageName, 1);
        });
        Paginator::useBootstrapFive();
        Table::$defaultDateDisplayFormat = 'Y-m-d';
        Table::$defaultDateTimeDisplayFormat = 'Y-m-d (H:i:s)';
        Infolist::$defaultDateDisplayFormat = 'Y-m-d';
        Infolist::$defaultDateTimeDisplayFormat = 'Y-m-d (H:i:s)';
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}

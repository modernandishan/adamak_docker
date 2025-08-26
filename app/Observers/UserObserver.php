<?php

namespace App\Observers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Wallet;
use App\Services\ReferralService;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if (! $user->profile) {
            Profile::create(['user_id' => $user->id]);
        }

        // ایجاد کیف پول خالی
        if (! $user->wallet) {
            Wallet::create(['user_id' => $user->id, 'balance' => 0]);
        }

        // اختصاص نقش پیش‌فرض - فقط اگر در حالت seeding نباشیم
        if (! $this->isSeeding() && ! $user->hasAnyRole()) {
            $user->assignRole('user');
        }

        // پیوند دادن کاربر به معرف در صورت وجود کوکی معرفی
        if (! $this->isSeeding()) {
            $referralService = app(ReferralService::class);
            $referralService->linkUserToReferral($user);
        }
    }

    private function isSeeding(): bool
    {
        return app()->runningInConsole() && (
            app()->bound('seeder') ||
            in_array('db:seed', $_SERVER['argv'] ?? []) ||
            str_contains(implode(' ', $_SERVER['argv'] ?? []), 'db:seed') ||
            app()->runningUnitTests()
        );
    }

    public function retrieved(User $user)
    {
        // اطمینان از وجود پروفایل
        if (! $user->profile) {
            Profile::create(['user_id' => $user->id]);
        }

        // اطمینان از وجود کیف پول
        if (! $user->wallet) {
            Wallet::create(['user_id' => $user->id, 'balance' => 0]);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}

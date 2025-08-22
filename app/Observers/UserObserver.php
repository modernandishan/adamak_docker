<?php

namespace App\Observers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Wallet;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if (!$user->profile) {
            Profile::create(['user_id' => $user->id]);
        }

        // ایجاد کیف پول خالی
        if (!$user->wallet) {
            Wallet::create(['user_id' => $user->id, 'balance' => 0]);
        }

        // اختصاص نقش پیش‌فرض
        if (!$user->hasAnyRole()) {
            $user->assignRole('user');
        }
    }

    public function retrieved(User $user)
    {
        // اطمینان از وجود پروفایل
        if (!$user->profile) {
            Profile::create(['user_id' => $user->id]);
        }

        // اطمینان از وجود کیف پول
        if (!$user->wallet) {
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

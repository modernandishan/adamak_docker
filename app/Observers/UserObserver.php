<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // First, create the associated profile, as you already do.
        $user->profile()->create();

        // THE SMART PART:
        // Check if the user ALREADY has a role.
        // The SuperAdminSeeder assigns a role right after creation,
        // so this condition will be FALSE for the super admin.
        // It will be TRUE for a regular user registering through a form.
        if (!$user->hasAnyRole()) {
            // Assign the default role for regular users.
            $user->assignRole('user');
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

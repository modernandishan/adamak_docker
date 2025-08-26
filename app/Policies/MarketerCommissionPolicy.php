<?php

namespace App\Policies;

use App\Models\MarketerCommission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MarketerCommissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_marketer::commission');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MarketerCommission $marketerCommission): bool
    {
        return $user->can('view_marketer::commission');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_marketer::commission');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MarketerCommission $marketerCommission): bool
    {
        return $user->can('update_marketer::commission');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MarketerCommission $marketerCommission): bool
    {
        return $user->can('delete_marketer::commission');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_marketer::commission');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, MarketerCommission $marketerCommission): bool
    {
        return $user->can('force_delete_marketer::commission');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_marketer::commission');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, MarketerCommission $marketerCommission): bool
    {
        return $user->can('restore_marketer::commission');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_marketer::commission');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, MarketerCommission $marketerCommission): bool
    {
        return $user->can('replicate_marketer::commission');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_marketer::commission');
    }
}

<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasRoleBasedNavigation
{
    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        // Always allow if no user is authenticated (during login process)
        if (! $user) {
            return true;
        }

        // Super admin and admin can see everything
        if ($user->hasAnyRole(['super_admin', 'admin'])) {
            return true;
        }

        // Define restricted resources for specific roles
        $resourceName = static::class;

        // Admin-only resources (super_admin and admin can access)
        $adminOnlyResources = [
            'App\Filament\Admin\Resources\AutomaticCommissionResource',
        ];

        // Marketer-only resources
        $marketerOnlyResources = [
            'App\Filament\Admin\Resources\MarketerUserResource',
            'App\Filament\Admin\Resources\MarketerCommissionResource',
        ];

        // Consultant-only resources
        $consultantOnlyResources = [
            'App\Filament\Admin\Resources\ConsultantBiographyResource',
        ];

        // Check if current user can access this resource
        if (in_array($resourceName, $adminOnlyResources)) {
            return $user->hasAnyRole(['super_admin', 'admin']);
        }

        if (in_array($resourceName, $marketerOnlyResources)) {
            return $user->hasRole('marketer');
        }

        if (in_array($resourceName, $consultantOnlyResources)) {
            return $user->hasRole('consultant');
        }

        // For all other resources, allow access
        return true;
    }
}

<?php

namespace Modules\ModuleBuilder\App\Policies;

use Modules\Auth\App\Models\User;
use Modules\ModuleBuilder\App\Models\DynamicModule;

class ModuleBuilderPolicy
{
    /**
     * Determine whether the user can view any modules.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'module-builder.view');
    }

    /**
     * Determine whether the user can view the module.
     */
    public function view(User $user, DynamicModule $module): bool
    {
        return $this->hasPermission($user, 'module-builder.view')
            && $this->belongsToTenant($user, $module);
    }

    /**
     * Determine whether the user can create modules.
     */
    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'module-builder.create');
    }

    /**
     * Determine whether the user can update the module.
     */
    public function update(User $user, DynamicModule $module): bool
    {
        return $this->hasPermission($user, 'module-builder.update')
            && $this->belongsToTenant($user, $module);
    }

    /**
     * Determine whether the user can delete the module.
     */
    public function delete(User $user, DynamicModule $module): bool
    {
        return $this->hasPermission($user, 'module-builder.delete')
            && $this->belongsToTenant($user, $module);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Check if the user has the given permission (Spatie-compatible or simple role check).
     */
    private function hasPermission(User $user, string $permission): bool
    {
        // If Spatie Permission package is installed
        if (method_exists($user, 'hasPermissionTo')) {
            return $user->hasPermissionTo($permission);
        }

        // Fallback: super-admin check or always true for development
        return $user->is_admin ?? true;
    }

    /**
     * Check if the module belongs to the user's tenant.
     */
    private function belongsToTenant(User $user, DynamicModule $module): bool
    {
        $userTenantId = $user->tenant_id ?? null;

        if ($userTenantId === null) {
            return true; // no tenant isolation
        }

        return $module->tenant_id === $userTenantId;
    }
}

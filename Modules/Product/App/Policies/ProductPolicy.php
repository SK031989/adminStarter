<?php

namespace Modules\Product\App\Policies;

use Modules\Auth\App\Models\User;
use Modules\Product\App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'products.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        return $this->hasPermission($user, 'products.view')
            && $this->belongsToTenant($user, $product);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'products.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        return $this->hasPermission($user, 'products.update')
            && $this->belongsToTenant($user, $product);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        return $this->hasPermission($user, 'products.delete')
            && $this->belongsToTenant($user, $product);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Check if the user has the given permission.
     */
    private function hasPermission(User $user, string $permission): bool
    {
        if (method_exists($user, 'hasPermissionTo')) {
            return $user->hasPermissionTo($permission);
        }

        return $user->is_admin ?? true;
    }

    /**
     * Check if the model belongs to the user's tenant.
     */
    private function belongsToTenant(User $user, Product $product): bool
    {
        $userTenantId = $user->tenant_id ?? null;

        if ($userTenantId === null) {
            return true;
        }

        return $product->tenant_id === $userTenantId;
    }
}
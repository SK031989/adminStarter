<?php

namespace Modules\Auth\App\Traits;

use Modules\Auth\App\Models\LoginActivity;

trait HasTenantAuth
{
    /**
     * Get the user's tenant.
     */
    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(
            class_exists(\Modules\Tenant\App\Models\Tenant::class)
                ? \Modules\Tenant\App\Models\Tenant::class
                : \App\Models\Tenant::class,
            'tenant_id'
        );
    }

    /**
     * Whether this user belongs to the given tenant.
     */
    public function belongsToTenant(int $tenantId): bool
    {
        return $this->tenant_id === $tenantId;
    }

    /**
     * Return the user's login activity history.
     */
    public function loginActivities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LoginActivity::class, 'user_id')->latest()->limit(50);
    }

    /**
     * Check if the user is currently within their tenant's active subscription.
     */
    public function hasTenantAccess(): bool
    {
        if (!$this->tenant_id) {
            return true;
        }

        if (!class_exists(\Modules\Tenant\App\Models\Tenant::class)) {
            return true;
        }

        $tenant = \Modules\Tenant\App\Models\Tenant::find($this->tenant_id);

        return $tenant && $tenant->status !== 'suspended';
    }
}

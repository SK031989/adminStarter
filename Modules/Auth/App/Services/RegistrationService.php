<?php

namespace Modules\Auth\App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\App\Enums\UserStatusEnum;
use Modules\Auth\App\Events\UserRegistered;
use Modules\Auth\App\Models\LoginActivity;
use Modules\Auth\App\Models\User;
use Modules\Auth\App\Repositories\UserRepository;

class RegistrationService
{
    public function __construct(protected UserRepository $userRepo) {}

    /**
     * Register a new user for the SaaS platform.
     * Creates user + optionally creates tenant.
     */
    public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {

            // Determine tenant_id
            $tenantId = $data['tenant_id'] ?? $this->resolveTenantId($data);

            // Set initial status
            $status = config('auth-module.registration.email_verification', true)
                ? UserStatusEnum::Pending
                : UserStatusEnum::Active;

            $user = $this->userRepo->create([
                'tenant_id'  => $tenantId,
                'name'       => $data['name'],
                'email'      => $data['email'],
                'password'   => Hash::make($data['password']),
                'phone'      => $data['phone'] ?? null,
                'status'     => $status,
                'is_admin'   => false,
            ]);

            // Log activity
            LoginActivity::record('register', 'success', $user->id, $tenantId);

            // Fire event — triggers welcome email + (optionally) tenant creation
            Event::dispatch(new UserRegistered($user));

            return $user;
        });
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Resolve the tenant_id for a new registration.
     * If auto-create is on, creates a new tenant record.
     */
    private function resolveTenantId(array $data): int
    {
        if (!config('auth-module.tenant.auto_create', false)) {
            return 1; // default tenant
        }

        // If Tenant module is available, create a new tenant
        if (class_exists(\Modules\Tenant\App\Models\Tenant::class)) {
            $tenant = \Modules\Tenant\App\Models\Tenant::create([
                'name'   => $data['company_name'] ?? $data['name'] . "'s Organization",
                'slug'   => \Illuminate\Support\Str::slug($data['company_name'] ?? $data['name']),
                'email'  => $data['email'],
                'plan'   => config('auth-module.tenant.default_plan', 'trial'),
                'status' => 'trial',
                'trial_ends_at' => now()->addDays(config('auth-module.tenant.trial_days', 14)),
                'tenant_id' => 0,
            ]);

            return $tenant->id;
        }

        return 1;
    }
}

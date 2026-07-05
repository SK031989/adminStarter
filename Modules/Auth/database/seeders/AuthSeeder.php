<?php

namespace Modules\Auth\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\App\Enums\UserStatusEnum;
use Modules\Auth\App\Models\User;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Auth users...');

        // 1. Create Core Spatie Roles
        $superAdminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $tenantAdminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Tenant Admin', 'guard_name' => 'web']);
        $userRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'User', 'guard_name' => 'web']);

        // 1. Super Admin (Global Admin)
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@saas.local'],
            [
                'tenant_id'          => 1,
                'name'               => 'SaaS Super Admin',
                'password'           => Hash::make('AdminPass123!'),
                'phone'              => '+1234567890',
                'status'             => UserStatusEnum::Active,
                'is_admin'           => true,
                'email_verified_at'  => now(),
            ]
        );
        $adminUser->assignRole($superAdminRole);

        // 2. Tenant 1 Admin
        $tenantAdmin = User::firstOrCreate(
            ['email' => 'tenant1@saas.local'],
            [
                'tenant_id'          => 1,
                'name'               => 'Tenant One Admin',
                'password'           => Hash::make('TenantPass123!'),
                'phone'              => '+1987654321',
                'status'             => UserStatusEnum::Active,
                'is_admin'           => false,
                'email_verified_at'  => now(),
            ]
        );
        $tenantAdmin->assignRole($tenantAdminRole);

        // 3. Demo Tenant User
        $demoUser = User::firstOrCreate(
            ['email' => 'user@saas.local'],
            [
                'tenant_id'          => 1,
                'name'               => 'Demo User',
                'password'           => Hash::make('UserPass123!'),
                'phone'              => '+1555555555',
                'status'             => UserStatusEnum::Active,
                'is_admin'           => false,
                'email_verified_at'  => now(),
            ]
        );
        $demoUser->assignRole($userRole);

        // 4. Pending Verification User
        $pendingUser = User::firstOrCreate(
            ['email' => 'pending@saas.local'],
            [
                'tenant_id'          => 1,
                'name'               => 'Pending User',
                'password'           => Hash::make('UserPass123!'),
                'status'             => UserStatusEnum::Pending,
                'is_admin'           => false,
                'email_verified_at'  => null,
            ]
        );
        $pendingUser->assignRole($userRole);

        $this->command->info('Auth users seeded successfully!');
    }
}

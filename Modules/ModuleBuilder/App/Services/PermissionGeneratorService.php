<?php

namespace Modules\ModuleBuilder\App\Services;

use Modules\ModuleBuilder\App\Models\DynamicModule;
use Modules\ModuleBuilder\App\Models\ModulePermission;

class PermissionGeneratorService
{
    /**
     * Create ModulePermission records and optionally sync with Spatie if installed.
     *
     * @return array<string>  List of created permission keys.
     */
    public function generate(DynamicModule $module): array
    {
        $slug    = $module->slug;
        $created = [];

        $permissions = ModulePermission::defaultKeysFor($slug);

        foreach ($permissions as $key => $label) {
            $permission = ModulePermission::firstOrCreate(
                [
                    'module_id'      => $module->id,
                    'permission_key' => $key,
                ],
                [
                    'tenant_id'  => $module->tenant_id,
                    'label'      => $label,
                    'guard_name' => 'web',
                    'status'     => 'active',
                ]
            );

            $created[] = $key;

            // If Spatie Permission package is installed, sync permissions there too
            if (class_exists(\Spatie\Permission\Models\Permission::class)) {
                \Spatie\Permission\Models\Permission::firstOrCreate(
                    ['name' => $key, 'guard_name' => 'web']
                );
            }
        }

        return $created;
    }

    /**
     * Remove all permissions for the given module.
     */
    public function revoke(DynamicModule $module): int
    {
        $slug = $module->slug;

        $count = ModulePermission::where('module_id', $module->id)->count();
        ModulePermission::where('module_id', $module->id)->delete();

        // Remove from Spatie if installed
        if (class_exists(\Spatie\Permission\Models\Permission::class)) {
            foreach (array_keys(ModulePermission::defaultKeysFor($slug)) as $key) {
                \Spatie\Permission\Models\Permission::where('name', $key)->delete();
            }
        }

        return $count;
    }
}

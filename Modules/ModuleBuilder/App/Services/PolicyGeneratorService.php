<?php

namespace Modules\ModuleBuilder\App\Services;

use Modules\ModuleBuilder\App\Models\DynamicModule;
use Illuminate\Support\Str;

class PolicyGeneratorService
{
    /**
     * Generate a Policy class for the given DynamicModule.
     */
    public function generate(DynamicModule $module): string
    {
        $className = $module->module_class_name;
        $basePath  = base_path("Modules/{$className}/App/Policies");

        if (!is_dir($basePath)) {
            mkdir($basePath, 0755, true);
        }

        $filePath = "{$basePath}/{$className}Policy.php";
        $content  = $this->buildPolicyContent($module);

        file_put_contents($filePath, $content);

        return $filePath;
    }

    /**
     * Build the Policy file content.
     */
    protected function buildPolicyContent(DynamicModule $module): string
    {
        $className = $module->module_class_name;
        $varName   = lcfirst($className);
        $slug      = $module->slug;

        return <<<PHP
<?php

namespace Modules\\{$className}\\App\\Policies;

use Modules\\Auth\\App\Models\\User;
use Modules\\{$className}\\App\\Models\\{$className};
use Illuminate\\Auth\\Access\\HandlesAuthorization;

class {$className}Policy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User \$user): bool
    {
        return \$this->hasPermission(\$user, '{$slug}.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User \$user, {$className} \${$varName}): bool
    {
        return \$this->hasPermission(\$user, '{$slug}.view')
            && \$this->belongsToTenant(\$user, \${$varName});
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User \$user): bool
    {
        return \$this->hasPermission(\$user, '{$slug}.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User \$user, {$className} \${$varName}): bool
    {
        return \$this->hasPermission(\$user, '{$slug}.update')
            && \$this->belongsToTenant(\$user, \${$varName});
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User \$user, {$className} \${$varName}): bool
    {
        return \$this->hasPermission(\$user, '{$slug}.delete')
            && \$this->belongsToTenant(\$user, \${$varName});
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Check if the user has the given permission.
     */
    private function hasPermission(User \$user, string \$permission): bool
    {
        if (method_exists(\$user, 'hasPermissionTo')) {
            return \$user->hasPermissionTo(\$permission);
        }

        return \$user->is_admin ?? true;
    }

    /**
     * Check if the model belongs to the user's tenant.
     */
    private function belongsToTenant(User \$user, {$className} \${$varName}): bool
    {
        \$userTenantId = \$user->tenant_id ?? null;

        if (\$userTenantId === null) {
            return true;
        }

        return \${$varName}->tenant_id === \$userTenantId;
    }
}
PHP;
    }
}

<?php

namespace Modules\ModuleBuilder\App\Services;

use Modules\ModuleBuilder\App\Models\DynamicModule;

class ServiceProviderGeneratorService
{
    /**
     * Generate both module.json and the Module Service Provider.
     *
     * @return array{module_json: string, service_provider: string}
     */
    public function generate(DynamicModule $module): array
    {
        $className = $module->module_class_name;
        $basePath  = base_path("Modules/{$className}");

        // Paths
        $moduleJsonPath = "{$basePath}/module.json";
        $providerPath   = "{$basePath}/App/Providers/{$className}ServiceProvider.php";

        // Create directory for provider
        if (!is_dir("{$basePath}/App/Providers")) {
            mkdir("{$basePath}/App/Providers", 0755, true);
        }

        // Write module.json
        file_put_contents($moduleJsonPath, $this->buildModuleJsonContent($module));

        // Write ServiceProvider
        file_put_contents($providerPath, $this->buildServiceProviderContent($module));

        return [
            'module_json'      => $moduleJsonPath,
            'service_provider' => $providerPath,
        ];
    }

    /**
     * Build module.json content.
     */
    protected function buildModuleJsonContent(DynamicModule $module): string
    {
        $className   = $module->module_class_name;
        $slug        = $module->slug;
        $description = $module->description ?? "Dynamic module for {$module->name}";

        $data = [
            'name'        => $className,
            'alias'       => $slug,
            'description' => $description,
            'keywords'    => [],
            'priority'    => 0,
            'providers'   => [
                "Modules\\{$className}\\App\\Providers\\{$className}ServiceProvider"
            ],
            'aliases'     => (object)[],
            'files'       => [],
            'requires'    => []
        ];

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Build ServiceProvider PHP content.
     */
    protected function buildServiceProviderContent(DynamicModule $module): string
    {
        $className = $module->module_class_name;
        $slug      = $module->slug;

        return <<<PHP
<?php

namespace Modules\\{$className}\\App\\Providers;

use Illuminate\\Support\\ServiceProvider;
use Illuminate\\Support\\Facades\\Route;
use Illuminate\\Support\\Facades\\Gate;
use Modules\\{$className}\\App\\Models\\{$className};
use Modules\\{$className}\\App\\Policies\\{$className}Policy;

class {$className}ServiceProvider extends ServiceProvider
{
    protected string \$moduleName = '{$className}';
    protected string \$moduleNameLower = '{$slug}';

    public function boot(): void
    {
        \$this->loadMigrationsFrom(module_path(\$this->moduleName, 'database/migrations'));
        \$this->loadViewsFrom(module_path(\$this->moduleName, 'resources/views'), \$this->moduleNameLower);
        \$this->loadRoutes();
        
        // Register policy
        Gate::policy({$className}::class, {$className}Policy::class);
    }

    protected function loadRoutes(): void
    {
        \$webRoutes = module_path(\$this->moduleName, 'routes/web.php');
        \$apiRoutes = module_path(\$this->moduleName, 'routes/api.php');

        if (file_exists(\$webRoutes)) {
            Route::middleware('web')->group(\$webRoutes);
        }

        if (file_exists(\$apiRoutes)) {
            Route::middleware('api')->group(\$apiRoutes);
        }
    }
}
PHP;
    }
}

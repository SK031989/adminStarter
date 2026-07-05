<?php

namespace Modules\ModuleBuilder\App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ModuleBuilder\App\Events\ModuleCreated;
use Modules\ModuleBuilder\App\Listeners\GenerateModuleFiles;
use Modules\ModuleBuilder\App\Models\DynamicModule;
use Modules\ModuleBuilder\App\Observers\ModuleObserver;
use Modules\ModuleBuilder\App\Policies\ModuleBuilderPolicy;
use Modules\ModuleBuilder\App\Repositories\FieldRepository;
use Modules\ModuleBuilder\App\Repositories\ModuleRepository;
use Modules\ModuleBuilder\App\Services\ControllerGeneratorService;
use Modules\ModuleBuilder\App\Services\MigrationGeneratorService;
use Modules\ModuleBuilder\App\Services\ModelGeneratorService;
use Modules\ModuleBuilder\App\Services\ModuleBuilderService;
use Modules\ModuleBuilder\App\Services\PermissionGeneratorService;
use Modules\ModuleBuilder\App\Services\PolicyGeneratorService;
use Modules\ModuleBuilder\App\Services\ServiceProviderGeneratorService;
use Modules\ModuleBuilder\App\Services\ViewGeneratorService;

class ModuleBuilderServiceProvider extends ServiceProvider
{
    /**
     * Module name — used for view/config namespacing.
     */
    protected string $moduleName = 'ModuleBuilder';

    /**
     * Module lower name — used for route and view namespace.
     */
    protected string $moduleNameLower = 'module-builder';

    // -------------------------------------------------------------------------
    // Boot
    // -------------------------------------------------------------------------

    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));

        // Register Routes
        $this->loadRoutes();

        // Register Observers
        DynamicModule::observe(ModuleObserver::class);

        // Register Events & Listeners
        Event::listen(ModuleCreated::class, GenerateModuleFiles::class);

        // Register Policies
        Gate::policy(DynamicModule::class, ModuleBuilderPolicy::class);
    }

    // -------------------------------------------------------------------------
    // Register
    // -------------------------------------------------------------------------

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        // Repositories
        $this->app->singleton(ModuleRepository::class);
        $this->app->singleton(FieldRepository::class);

        // Generator Services
        $this->app->singleton(MigrationGeneratorService::class);
        $this->app->singleton(ModelGeneratorService::class);
        $this->app->singleton(ControllerGeneratorService::class);
        $this->app->singleton(ViewGeneratorService::class);
        $this->app->singleton(PermissionGeneratorService::class);
        $this->app->singleton(PolicyGeneratorService::class);
        $this->app->singleton(ServiceProviderGeneratorService::class);

        // Main Service
        $this->app->singleton(ModuleBuilderService::class);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'config/modulebuilder.php') => config_path('modulebuilder.php'),
        ], 'config');

        $this->mergeConfigFrom(
            module_path($this->moduleName, 'config/modulebuilder.php'),
            'modulebuilder'
        );
    }

    protected function registerViews(): void
    {
        $viewPath   = resource_path('views/modules/' . $this->moduleNameLower);
        $sourcePath = module_path($this->moduleName, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(
            array_merge($this->getPublishableViewPaths(), [$sourcePath]),
            $this->moduleNameLower
        );
    }

    protected function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'resources/lang'));
        }
    }

    protected function loadRoutes(): void
    {
        $webRoutes     = module_path($this->moduleName, 'routes/web.php');
        $apiRoutes     = module_path($this->moduleName, 'routes/api.php');
        $consoleRoutes = module_path($this->moduleName, 'routes/console.php');

        if (file_exists($webRoutes)) {
            $this->loadRoutesFrom($webRoutes);
        }

        if (file_exists($apiRoutes)) {
            $this->loadRoutesFrom($apiRoutes);
        }

        if (file_exists($consoleRoutes)) {
            require $consoleRoutes;
        }
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];

        foreach (config('view.paths') as $path) {
            $viewPath = $path . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $this->moduleNameLower;
            if (is_dir($viewPath)) {
                $paths[] = $viewPath;
            }
        }

        return $paths;
    }
}

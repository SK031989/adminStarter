<?php

namespace Modules\Dashboard\App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Dashboard';
    protected string $moduleNameLower = 'dashboard';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerViews();
        $this->registerRoutes();
    }

    /**
     * Register the module routes.
     */
    protected function registerRoutes(): void
    {
        $routesPath = module_path($this->moduleName, 'routes/web.php');
        if (file_exists($routesPath)) {
            $this->loadRoutesFrom($routesPath);
        }
    }

    /**
     * Register the module views.
     */
    protected function registerViews(): void
    {
        $viewPath = module_path($this->moduleName, 'resources/views');
        if (is_dir($viewPath)) {
            $this->loadViewsFrom($viewPath, $this->moduleNameLower);
        }
    }
}

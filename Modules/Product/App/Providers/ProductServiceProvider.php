<?php

namespace Modules\Product\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Modules\Product\App\Models\Product;
use Modules\Product\App\Policies\ProductPolicy;

class ProductServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Product';
    protected string $moduleNameLower = 'products';

    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
        $this->loadViewsFrom(module_path($this->moduleName, 'resources/views'), $this->moduleNameLower);
        $this->loadRoutes();
        
        // Register policy
        Gate::policy(Product::class, ProductPolicy::class);
    }

    protected function loadRoutes(): void
    {
        $webRoutes = module_path($this->moduleName, 'routes/web.php');
        $apiRoutes = module_path($this->moduleName, 'routes/api.php');

        if (file_exists($webRoutes)) {
            Route::middleware('web')->group($webRoutes);
        }

        if (file_exists($apiRoutes)) {
            Route::middleware('api')->group($apiRoutes);
        }
    }
}
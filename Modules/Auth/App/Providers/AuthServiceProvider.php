<?php

namespace Modules\Auth\App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\App\Events\UserLoggedIn;
use Modules\Auth\App\Events\UserLoggedOut;
use Modules\Auth\App\Events\UserRegistered;
use Modules\Auth\App\Listeners\LogAuthActivity;
use Modules\Auth\App\Listeners\SendWelcomeEmail;
use Modules\Auth\App\Models\User;
use Modules\Auth\App\Observers\UserObserver;
use Modules\Auth\App\Policies\UserPolicy;
use Modules\Auth\App\Repositories\UserRepository;
use Modules\Auth\App\Services\AuthService;
use Modules\Auth\App\Services\PasswordResetService;
use Modules\Auth\App\Services\ProfileService;
use Modules\Auth\App\Services\RegistrationService;

class AuthServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Auth';
    protected string $moduleNameLower = 'auth-module';

    public function boot(): void
    {
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));

        // Register Observers
        User::observe(UserObserver::class);

        // Register Policies
        Gate::policy(User::class, UserPolicy::class);

        // Global bypass for Super Admins
        Gate::before(function ($user, $ability) {
            return $user->isAdmin() ? true : null;
        });

        // Register Events & Listeners
        Event::listen(UserRegistered::class, SendWelcomeEmail::class);
        Event::listen(UserRegistered::class, [LogAuthActivity::class, 'handleRegistered']);
        Event::listen(UserLoggedIn::class, [LogAuthActivity::class, 'handleLoggedIn']);
        Event::listen(UserLoggedOut::class, [LogAuthActivity::class, 'handleLoggedOut']);

        // Load Routes
        $this->loadRoutes();
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        // Bind Repository
        $this->app->singleton(UserRepository::class);

        // Bind Services
        $this->app->singleton(AuthService::class);
        $this->app->singleton(RegistrationService::class);
        $this->app->singleton(PasswordResetService::class);
        $this->app->singleton(ProfileService::class);
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'config/auth-module.php') => config_path('auth-module.php'),
        ], 'config');

        $this->mergeConfigFrom(
            module_path($this->moduleName, 'config/auth-module.php'),
            'auth-module'
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
}

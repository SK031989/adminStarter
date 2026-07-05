<?php

use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| ModuleBuilder Console Routes
|--------------------------------------------------------------------------
*/

Artisan::command('module-builder:generate {module}', function (string $module) {
    /** @var \Modules\ModuleBuilder\App\Repositories\ModuleRepository $repo */
    $repo = app(\Modules\ModuleBuilder\App\Repositories\ModuleRepository::class);

    $dynamicModule = $repo->findBySlug(\Illuminate\Support\Str::slug($module));

    if (!$dynamicModule) {
        $this->error("Module [{$module}] not found.");
        return 1;
    }

    $this->info("Generating files for module [{$dynamicModule->name}]...");

    /** @var \Modules\ModuleBuilder\App\Services\ModuleBuilderService $service */
    $service = app(\Modules\ModuleBuilder\App\Services\ModuleBuilderService::class);

    $files = $service->generateModule($dynamicModule);

    $this->info('Generated files:');
    foreach ($files as $type => $path) {
        if (is_array($path)) {
            foreach ($path as $p) {
                $this->line("  [{$type}] {$p}");
            }
        } else {
            $this->line("  [{$type}] {$path}");
        }
    }

    $this->info("Module [{$dynamicModule->name}] generated successfully!");
    return 0;
})->purpose('Generate all files for a dynamic module by its slug/name');


Artisan::command('module-builder:list', function () {
    /** @var \Modules\ModuleBuilder\App\Repositories\ModuleRepository $repo */
    $repo    = app(\Modules\ModuleBuilder\App\Repositories\ModuleRepository::class);
    $modules = $repo->all();

    $this->table(
        ['ID', 'Name', 'Slug', 'Fields', 'Generated', 'Status'],
        $modules->map(fn ($m) => [
            $m->id,
            $m->name,
            $m->slug,
            $m->fields->count(),
            $m->is_generated ? '✓' : '✗',
            $m->status,
        ])->toArray()
    );
})->purpose('List all dynamic modules with their generation status');

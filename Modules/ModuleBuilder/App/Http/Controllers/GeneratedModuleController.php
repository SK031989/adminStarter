<?php

namespace Modules\ModuleBuilder\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\ModuleBuilder\App\Models\DynamicModule;
use Modules\ModuleBuilder\App\Services\ModuleBuilderService;

class GeneratedModuleController extends Controller
{
    public function __construct(protected ModuleBuilderService $service) {}

    /**
     * Trigger code generation for the given module.
     * Dispatches the generation job and returns to the show page.
     */
    public function generate(DynamicModule $moduleBuilder): RedirectResponse
    {
        $this->authorize('update', $moduleBuilder);

        if ($moduleBuilder->fields->isEmpty()) {
            return redirect()
                ->route('module-builder.show', $moduleBuilder)
                ->with('error', 'Please add at least one field before generating.');
        }

        $generated = $this->service->generateModule($moduleBuilder);

        $count = count(array_filter(array_values($generated), fn ($v) => !is_array($v)));
        $viewCount = is_array($generated['views']) ? count($generated['views']) : 0;

        return redirect()
            ->route('module-builder.show', $moduleBuilder)
            ->with('success', "Module generated successfully! ({$count} files + {$viewCount} views)");
    }

    /**
     * API: Return generation status as JSON.
     */
    public function status(DynamicModule $moduleBuilder): JsonResponse
    {
        $this->authorize('view', $moduleBuilder);

        return response()->json([
            'module'          => $moduleBuilder->name,
            'is_generated'    => $moduleBuilder->is_generated,
            'generation_path' => $moduleBuilder->generation_path,
            'fields_count'    => $moduleBuilder->fields()->count(),
        ]);
    }

    /**
     * Preview the list of files that would be generated (dry-run).
     */
    public function preview(DynamicModule $moduleBuilder): JsonResponse
    {
        $this->authorize('view', $moduleBuilder);

        $className = $moduleBuilder->module_class_name;
        $basePath  = "Modules/{$className}";

        return response()->json([
            'files' => [
                'module_json' => "{$basePath}/module.json",
                'service_provider' => "{$basePath}/App/Providers/{$className}ServiceProvider.php",
                'policy'     => "{$basePath}/App/Policies/{$className}Policy.php",
                'migration'  => "{$basePath}/database/migrations/create_{$moduleBuilder->table_name}_table.php",
                'model'      => "{$basePath}/App/Models/{$className}.php",
                'controller' => "{$basePath}/App/Http/Controllers/{$className}Controller.php",
                'api_controller' => "{$basePath}/App/Http/Controllers/{$className}ApiController.php",
                'store_request'  => "{$basePath}/App/Http/Requests/Store{$className}Request.php",
                'update_request' => "{$basePath}/App/Http/Requests/Update{$className}Request.php",
                'views' => [
                    "{$basePath}/resources/views/index.blade.php",
                    "{$basePath}/resources/views/create.blade.php",
                    "{$basePath}/resources/views/edit.blade.php",
                    "{$basePath}/resources/views/show.blade.php",
                    "{$basePath}/resources/views/partials/form.blade.php",
                    "{$basePath}/resources/views/partials/table.blade.php",
                    "{$basePath}/resources/views/partials/filters.blade.php",
                    "{$basePath}/resources/views/partials/actions.blade.php",
                ],
                'routes' => [
                    "{$basePath}/routes/web.php",
                    "{$basePath}/routes/api.php",
                ],
            ],
        ]);
    }
}

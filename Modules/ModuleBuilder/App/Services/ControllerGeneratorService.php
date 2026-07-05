<?php

namespace Modules\ModuleBuilder\App\Services;

use Modules\ModuleBuilder\App\Models\DynamicModule;

class ControllerGeneratorService
{
    /**
     * Generate a full Resource Controller for the given DynamicModule.
     */
    public function generate(DynamicModule $module): string
    {
        $className = $module->module_class_name;
        $basePath  = base_path("Modules/{$className}/App/Http/Controllers");

        if (!is_dir($basePath)) {
            mkdir($basePath, 0755, true);
        }

        // Web Controller
        $webPath    = "{$basePath}/{$className}Controller.php";
        file_put_contents($webPath, $this->buildWebController($module));

        // API Controller
        $apiPath    = "{$basePath}/{$className}ApiController.php";
        file_put_contents($apiPath, $this->buildApiController($module));

        // Also generate FormRequest files
        $this->generateRequests($module);

        return $webPath;
    }

    // -------------------------------------------------------------------------
    // Web Controller
    // -------------------------------------------------------------------------

    private function buildWebController(DynamicModule $module): string
    {
        $className  = $module->module_class_name;
        $varName    = lcfirst($className);
        $routeName  = $module->route_name;
        $viewPrefix = $routeName;
        $tableName  = $module->table_name;

        return <<<PHP
<?php

namespace Modules\\{$className}\\App\\Http\\Controllers;

use App\\Http\\Controllers\\Controller;
use Illuminate\\Http\\Request;
use Illuminate\\Http\\RedirectResponse;
use Illuminate\\View\\View;
use Modules\\{$className}\\App\\Models\\{$className};
use Modules\\{$className}\\App\\Http\\Requests\\Store{$className}Request;
use Modules\\{$className}\\App\\Http\\Requests\\Update{$className}Request;

class {$className}Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request \$request)
    {
        if (auth()->check()) {
            \$isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
            if (\$isAdminCase && !request()->is('admin/*')) {
                return redirect('/admin/' . request()->path());
            } elseif (!\$isAdminCase && request()->is('admin/*')) {
                return redirect('/' . preg_replace('/^admin\//', '', request()->path()));
            }
        }

        \$this->authorize('viewAny', {$className}::class);

        \${$varName}s = {$className}::query()
            ->forTenant(auth()->user()->tenant_id)
            ->when(\$request->search, fn (\$q) => \$q->search(\$request->search))
            ->when(\$request->status, fn (\$q) => \$q->where('status', \$request->status))
            ->latest()
            ->paginate(config('modulebuilder.pagination.per_page', 15))
            ->withQueryString();

        return view('{$viewPrefix}::index', compact('{$varName}s'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->check()) {
            \$isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
            if (\$isAdminCase && !request()->is('admin/*')) {
                return redirect('/admin/' . request()->path());
            } elseif (!\$isAdminCase && request()->is('admin/*')) {
                return redirect('/' . preg_replace('/^admin\//', '', request()->path()));
            }
        }

        \$this->authorize('create', {$className}::class);

        return view('{$viewPrefix}::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store{$className}Request \$request): RedirectResponse
    {
        \$this->authorize('create', {$className}::class);

        \$data              = \$request->validated();
        \$data['tenant_id'] = auth()->user()->tenant_id;

        {$className}::create(\$data);

        \$isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
        \$route = \$isAdminCase ? 'admin.{$routeName}.index' : '{$routeName}.index';
        return redirect()
            ->route(\$route)
            ->with('success', '{$className} created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show({$className} \${$varName})
    {
        if (auth()->check()) {
            \$isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
            if (\$isAdminCase && !request()->is('admin/*')) {
                return redirect('/admin/' . request()->path());
            } elseif (!\$isAdminCase && request()->is('admin/*')) {
                return redirect('/' . preg_replace('/^admin\//', '', request()->path()));
            }
        }

        \$this->authorize('view', \${$varName});

        return view('{$viewPrefix}::show', compact('{$varName}'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit({$className} \${$varName})
    {
        if (auth()->check()) {
            \$isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
            if (\$isAdminCase && !request()->is('admin/*')) {
                return redirect('/admin/' . request()->path());
            } elseif (!\$isAdminCase && request()->is('admin/*')) {
                return redirect('/' . preg_replace('/^admin\//', '', request()->path()));
            }
        }

        \$this->authorize('update', \${$varName});

        return view('{$viewPrefix}::edit', compact('{$varName}'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update{$className}Request \$request, {$className} \${$varName}): RedirectResponse
    {
        \$this->authorize('update', \${$varName});

        \${$varName}->update(\$request->validated());

        \$isAdminCase = auth()->user()->is_admin || auth()->user()->hasRole('Tenant Admin');
        \$route = \$isAdminCase ? 'admin.{$routeName}.index' : '{$routeName}.index';
        return redirect()
            ->route(\$route)
            ->with('success', '{$className} updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy({$className} \${$varName}): RedirectResponse
    {
        \$this->authorize('delete', \${$varName});

        \${$varName}->delete();

        \$route = auth()->user()->is_admin ? 'admin.{$routeName}.index' : '{$routeName}.index';
        return redirect()
            ->route(\$route)
            ->with('success', '{$className} deleted successfully.');
    }
}
PHP;
    }

    // -------------------------------------------------------------------------
    // API Controller
    // -------------------------------------------------------------------------

    private function buildApiController(DynamicModule $module): string
    {
        $className = $module->module_class_name;
        $varName   = lcfirst($className);
        $routeName = $module->route_name;

        return <<<PHP
<?php

namespace Modules\\{$className}\\App\\Http\\Controllers;

use App\\Http\\Controllers\\Controller;
use Illuminate\\Http\\JsonResponse;
use Illuminate\\Http\\Request;
use Modules\\{$className}\\App\\Models\\{$className};
use Modules\\{$className}\\App\\Http\\Requests\\Store{$className}Request;
use Modules\\{$className}\\App\\Http\\Requests\\Update{$className}Request;

class {$className}ApiController extends Controller
{
    /**
     * GET /api/v1/{$routeName}
     */
    public function index(Request \$request): JsonResponse
    {
        \$this->authorize('viewAny', {$className}::class);

        \$items = {$className}::query()
            ->forTenant(auth()->user()->tenant_id)
            ->when(\$request->search, fn(\$q) => \$q->search(\$request->search))
            ->latest()
            ->paginate(\$request->per_page ?? 15);

        return response()->json(\$items);
    }

    /**
     * POST /api/v1/{$routeName}
     */
    public function store(Store{$className}Request \$request): JsonResponse
    {
        \$this->authorize('create', {$className}::class);

        \$data              = \$request->validated();
        \$data['tenant_id'] = auth()->user()->tenant_id;

        \$item = {$className}::create(\$data);

        return response()->json(['data' => \$item, 'message' => '{$className} created.'], 201);
    }

    /**
     * GET /api/v1/{$routeName}/{id}
     */
    public function show({$className} \${$varName}): JsonResponse
    {
        \$this->authorize('view', \${$varName});

        return response()->json(['data' => \${$varName}]);
    }

    /**
     * PUT /api/v1/{$routeName}/{id}
     */
    public function update(Update{$className}Request \$request, {$className} \${$varName}): JsonResponse
    {
        \$this->authorize('update', \${$varName});

        \${$varName}->update(\$request->validated());

        return response()->json(['data' => \${$varName}->fresh(), 'message' => '{$className} updated.']);
    }

    /**
     * DELETE /api/v1/{$routeName}/{id}
     */
    public function destroy({$className} \${$varName}): JsonResponse
    {
        \$this->authorize('delete', \${$varName});

        \${$varName}->delete();

        return response()->json(['message' => '{$className} deleted.']);
    }
}
PHP;
    }

    // -------------------------------------------------------------------------
    // Form Requests
    // -------------------------------------------------------------------------

    private function generateRequests(DynamicModule $module): void
    {
        $className    = $module->module_class_name;
        $requestsPath = base_path("Modules/{$className}/App/Http/Requests");

        if (!is_dir($requestsPath)) {
            mkdir($requestsPath, 0755, true);
        }

        $storeRules  = $this->buildValidationRules($module, 'store');
        $updateRules = $this->buildValidationRules($module, 'update');

        // Store Request
        file_put_contents("{$requestsPath}/Store{$className}Request.php", <<<PHP
<?php

namespace Modules\\{$className}\\App\\Http\\Requests;

use Illuminate\\Foundation\\Http\\FormRequest;

class Store{$className}Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
{$storeRules}
        ];
    }
}
PHP);

        // Update Request
        file_put_contents("{$requestsPath}/Update{$className}Request.php", <<<PHP
<?php

namespace Modules\\{$className}\\App\\Http\\Requests;

use Illuminate\\Foundation\\Http\\FormRequest;

class Update{$className}Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
{$updateRules}
        ];
    }
}
PHP);
    }

    private function buildValidationRules(DynamicModule $module, string $mode): string
    {
        $lines = [];

        foreach ($module->fields as $field) {
            $rules = [];

            if ($field->is_required && $mode === 'store') {
                $rules[] = 'required';
            } else {
                $rules[] = 'nullable';
            }

            if (!empty($field->validation_rules)) {
                $extra = array_filter(explode('|', $field->validation_rules));
                $rules = array_merge($rules, $extra);
            }

            if ($field->type->isFileType()) {
                $rules[] = $field->type->value === 'image' ? 'image' : 'file';
                $rules[] = 'max:10240';
            }

            $rulesStr = implode('|', $rules);
            $lines[]  = "            '{$field->field_name}' => '{$rulesStr}',";
        }

        return implode("\n", $lines);
    }
}

<?php

namespace Modules\ModuleBuilder\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\ModuleBuilder\App\Http\Requests\StoreModuleRequest;
use Modules\ModuleBuilder\App\Http\Requests\UpdateModuleRequest;
use Modules\ModuleBuilder\App\Models\DynamicModule;
use Modules\ModuleBuilder\App\Repositories\ModuleRepository;
use Modules\ModuleBuilder\App\Services\ModuleBuilderService;

class ModuleBuilderController extends Controller
{
    public function __construct(
        protected ModuleRepository    $repo,
        protected ModuleBuilderService $service
    ) {}

    // -------------------------------------------------------------------------
    // index
    // -------------------------------------------------------------------------

    public function index(Request $request): View
    {
        $this->authorize('viewAny', DynamicModule::class);

        $modules = $this->repo->paginate(
            config('modulebuilder.pagination.per_page', 15),
            $request->only(['search', 'status', 'tenant_id'])
        );

        $stats = $this->repo->countByStatus();

        return view('module-builder::index', compact('modules', 'stats'));
    }

    // -------------------------------------------------------------------------
    // create
    // -------------------------------------------------------------------------

    public function create(): View
    {
        $this->authorize('create', DynamicModule::class);

        return view('module-builder::create');
    }

    // -------------------------------------------------------------------------
    // store
    // -------------------------------------------------------------------------

    public function store(StoreModuleRequest $request): RedirectResponse
    {
        $this->authorize('create', DynamicModule::class);

        $data              = $request->validated();
        $data['tenant_id'] = auth()->user()->tenant_id ?? 1;

        $module = $this->service->createModule($data);

        return redirect()
            ->route('module-builder.show', $module)
            ->with('success', "Module \"{$module->name}\" created. Files will be generated shortly.");
    }

    // -------------------------------------------------------------------------
    // show
    // -------------------------------------------------------------------------

    public function show(DynamicModule $moduleBuilder): View
    {
        $this->authorize('view', $moduleBuilder);

        $moduleBuilder->load(['fields', 'permissions', 'menu']);

        return view('module-builder::show', ['module' => $moduleBuilder]);
    }

    // -------------------------------------------------------------------------
    // edit
    // -------------------------------------------------------------------------

    public function edit(DynamicModule $moduleBuilder): View
    {
        $this->authorize('update', $moduleBuilder);

        $moduleBuilder->load('fields');

        return view('module-builder::edit', ['module' => $moduleBuilder]);
    }

    // -------------------------------------------------------------------------
    // update
    // -------------------------------------------------------------------------

    public function update(UpdateModuleRequest $request, DynamicModule $moduleBuilder): RedirectResponse
    {
        $this->authorize('update', $moduleBuilder);

        $module = $this->service->updateModule($moduleBuilder, $request->validated());

        return redirect()
            ->route('module-builder.show', $module)
            ->with('success', "Module \"{$module->name}\" updated successfully.");
    }

    // -------------------------------------------------------------------------
    // destroy
    // -------------------------------------------------------------------------

    public function destroy(DynamicModule $moduleBuilder): RedirectResponse
    {
        $this->authorize('delete', $moduleBuilder);

        $name = $moduleBuilder->name;
        $this->service->deleteModule($moduleBuilder);

        return redirect()
            ->route('module-builder.index')
            ->with('success', "Module \"{$name}\" deleted.");
    }
}

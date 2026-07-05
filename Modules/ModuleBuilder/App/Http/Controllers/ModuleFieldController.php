<?php

namespace Modules\ModuleBuilder\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\ModuleBuilder\App\Http\Requests\StoreFieldRequest;
use Modules\ModuleBuilder\App\Models\DynamicField;
use Modules\ModuleBuilder\App\Models\DynamicModule;
use Modules\ModuleBuilder\App\Repositories\FieldRepository;

class ModuleFieldController extends Controller
{
    public function __construct(protected FieldRepository $repo) {}

    /**
     * Store a new field for the given module.
     */
    public function store(StoreFieldRequest $request, DynamicModule $moduleBuilder): RedirectResponse
    {
        $this->authorize('update', $moduleBuilder);

        $this->repo->create($moduleBuilder, $request->validated());

        return redirect()
            ->route('module-builder.edit', $moduleBuilder)
            ->with('success', 'Field added successfully.');
    }

    /**
     * Update a field.
     */
    public function update(Request $request, DynamicModule $moduleBuilder, DynamicField $field): RedirectResponse
    {
        $this->authorize('update', $moduleBuilder);

        $validated = $request->validate([
            'label'            => ['required', 'string', 'max:100'],
            'is_required'      => ['boolean'],
            'is_searchable'    => ['boolean'],
            'is_filterable'    => ['boolean'],
            'default_value'    => ['nullable', 'string', 'max:255'],
            'validation_rules' => ['nullable', 'string', 'max:500'],
            'placeholder'      => ['nullable', 'string', 'max:255'],
            'help_text'        => ['nullable', 'string', 'max:500'],
            'options'          => ['nullable', 'array'],
        ]);

        $this->repo->update($field, $validated);

        return redirect()
            ->route('module-builder.edit', $moduleBuilder)
            ->with('success', 'Field updated.');
    }

    /**
     * Delete a field.
     */
    public function destroy(DynamicModule $moduleBuilder, DynamicField $field): RedirectResponse
    {
        $this->authorize('update', $moduleBuilder);

        $this->repo->delete($field);

        return redirect()
            ->route('module-builder.edit', $moduleBuilder)
            ->with('success', 'Field removed.');
    }

    /**
     * Reorder fields via AJAX POST of ordered IDs.
     */
    public function reorder(Request $request, DynamicModule $moduleBuilder): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', $moduleBuilder);

        $ids = $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer'],
        ])['ids'];

        $this->repo->reorder($moduleBuilder, $ids);

        return response()->json(['message' => 'Fields reordered.']);
    }
}

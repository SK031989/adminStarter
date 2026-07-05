<?php

namespace Modules\ModuleBuilder\App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\ModuleBuilder\App\Models\DynamicField;
use Modules\ModuleBuilder\App\Models\DynamicModule;

class FieldRepository
{
    public function __construct(protected DynamicField $model) {}

    // -------------------------------------------------------------------------
    // Read
    // -------------------------------------------------------------------------

    public function forModule(DynamicModule $module): Collection
    {
        return $this->model
            ->where('module_id', $module->id)
            ->orderBy('sort_order')
            ->get();
    }

    public function find(int $id): ?DynamicField
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): DynamicField
    {
        return $this->model->findOrFail($id);
    }

    public function searchableFields(DynamicModule $module): Collection
    {
        return $this->model
            ->where('module_id', $module->id)
            ->searchable()
            ->get();
    }

    public function filterableFields(DynamicModule $module): Collection
    {
        return $this->model
            ->where('module_id', $module->id)
            ->filterable()
            ->get();
    }

    // -------------------------------------------------------------------------
    // Write
    // -------------------------------------------------------------------------

    public function create(DynamicModule $module, array $data): DynamicField
    {
        $data['module_id']  = $module->id;
        $data['tenant_id']  = $module->tenant_id;
        $data['sort_order'] = $this->nextSortOrder($module);

        return $this->model->create($data);
    }

    public function update(DynamicField $field, array $data): DynamicField
    {
        $field->update($data);
        return $field->fresh();
    }

    public function delete(DynamicField $field): bool
    {
        return $field->delete();
    }

    public function reorder(DynamicModule $module, array $orderedIds): void
    {
        foreach ($orderedIds as $index => $id) {
            $this->model
                ->where('id', $id)
                ->where('module_id', $module->id)
                ->update(['sort_order' => $index + 1]);
        }
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function nextSortOrder(DynamicModule $module): int
    {
        return (int) $this->model
            ->where('module_id', $module->id)
            ->max('sort_order') + 1;
    }
}

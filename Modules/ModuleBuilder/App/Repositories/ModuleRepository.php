<?php

namespace Modules\ModuleBuilder\App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\ModuleBuilder\App\Models\DynamicModule;

class ModuleRepository
{
    public function __construct(protected DynamicModule $model) {}

    // -------------------------------------------------------------------------
    // Read
    // -------------------------------------------------------------------------

    public function all(): Collection
    {
        return $this->model->with('fields')->latest()->get();
    }

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->with('fields');

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['tenant_id'])) {
            $query->forTenant((int) $filters['tenant_id']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function find(int $id): ?DynamicModule
    {
        return $this->model->with(['fields', 'permissions', 'menu'])->find($id);
    }

    public function findOrFail(int $id): DynamicModule
    {
        return $this->model->with(['fields', 'permissions', 'menu'])->findOrFail($id);
    }

    public function findBySlug(string $slug): ?DynamicModule
    {
        return $this->model->where('slug', $slug)->first();
    }

    // -------------------------------------------------------------------------
    // Write
    // -------------------------------------------------------------------------

    public function create(array $data): DynamicModule
    {
        return $this->model->create($data);
    }

    public function update(DynamicModule $module, array $data): DynamicModule
    {
        $module->update($data);
        return $module->fresh(['fields', 'permissions', 'menu']);
    }

    public function delete(DynamicModule $module): bool
    {
        return $module->delete();
    }

    public function markGenerated(DynamicModule $module, string $path): DynamicModule
    {
        $module->update([
            'is_generated'    => true,
            'generation_path' => $path,
        ]);
        return $module->fresh();
    }

    // -------------------------------------------------------------------------
    // Counts
    // -------------------------------------------------------------------------

    public function countByStatus(): array
    {
        return $this->model
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
    }
}

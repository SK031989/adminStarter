<?php

namespace Modules\ModuleBuilder\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\ModuleBuilder\database\factories\DynamicModuleFactory;

class DynamicModule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dynamic_modules';

    protected $fillable = [
        'tenant_id',
        'name',
        'slug',
        'icon',
        'description',
        'is_generated',
        'generation_path',
        'status',
        'sort_order',
        'settings',
    ];

    protected $casts = [
        'is_generated' => 'boolean',
        'settings'     => 'array',
        'sort_order'   => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Factory
    // -------------------------------------------------------------------------

    protected static function newFactory(): DynamicModuleFactory
    {
        return DynamicModuleFactory::new();
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function fields(): HasMany
    {
        return $this->hasMany(DynamicField::class, 'module_id')->orderBy('sort_order');
    }

    public function menu(): HasMany
    {
        return $this->hasMany(ModuleMenu::class, 'module_id');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(ModulePermission::class, 'module_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeGenerated($query)
    {
        return $query->where('is_generated', true);
    }

    public function scopeForTenant($query, int $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeSearch($query, ?string $term)
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('slug', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%");
        });
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    public function getModuleClassNameAttribute(): string
    {
        return \Illuminate\Support\Str::studly($this->name);
    }

    public function getTableNameAttribute(): string
    {
        return \Illuminate\Support\Str::snake(\Illuminate\Support\Str::plural($this->name));
    }

    public function getRouteNameAttribute(): string
    {
        return \Illuminate\Support\Str::kebab(\Illuminate\Support\Str::plural($this->name));
    }
}

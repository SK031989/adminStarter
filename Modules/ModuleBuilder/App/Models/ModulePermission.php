<?php

namespace Modules\ModuleBuilder\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModulePermission extends Model
{
    use SoftDeletes;

    protected $table = 'module_permissions';

    protected $fillable = [
        'tenant_id',
        'module_id',
        'permission_key',
        'label',
        'guard_name',
        'status',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function module(): BelongsTo
    {
        return $this->belongsTo(DynamicModule::class, 'module_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForModule($query, int $moduleId)
    {
        return $query->where('module_id', $moduleId);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Standard CRUD permission keys for a module slug.
     */
    public static function defaultKeysFor(string $slug): array
    {
        return [
            "{$slug}.view"   => "View {$slug}",
            "{$slug}.create" => "Create {$slug}",
            "{$slug}.update" => "Update {$slug}",
            "{$slug}.delete" => "Delete {$slug}",
        ];
    }
}

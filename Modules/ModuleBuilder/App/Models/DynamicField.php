<?php

namespace Modules\ModuleBuilder\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\ModuleBuilder\App\Enums\FieldTypeEnum;
use Modules\ModuleBuilder\database\factories\DynamicFieldFactory;

class DynamicField extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dynamic_fields';

    protected $fillable = [
        'tenant_id',
        'module_id',
        'field_name',
        'label',
        'type',
        'is_required',
        'is_searchable',
        'is_filterable',
        'is_sortable',
        'is_nullable',
        'default_value',
        'options',
        'validation_rules',
        'placeholder',
        'help_text',
        'sort_order',
        'status',
        'settings',
    ];

    protected $casts = [
        'type'           => FieldTypeEnum::class,
        'is_required'    => 'boolean',
        'is_searchable'  => 'boolean',
        'is_filterable'  => 'boolean',
        'is_sortable'    => 'boolean',
        'is_nullable'    => 'boolean',
        'options'        => 'array',
        'settings'       => 'array',
        'sort_order'     => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Factory
    // -------------------------------------------------------------------------

    protected static function newFactory(): DynamicFieldFactory
    {
        return DynamicFieldFactory::new();
    }

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

    public function scopeSearchable($query)
    {
        return $query->where('is_searchable', true);
    }

    public function scopeFilterable($query)
    {
        return $query->where('is_filterable', true);
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    public function getValidationRulesArrayAttribute(): array
    {
        if (empty($this->validation_rules)) {
            return [];
        }
        return array_filter(explode('|', $this->validation_rules));
    }

    public function getColumnDefinitionAttribute(): string
    {
        $colType = $this->type->migrationColumnType();
        $col = "\$table->{$colType}('{$this->field_name}'";

        if ($colType === 'decimal') {
            $col .= ', 15, 2';
        }

        $col .= ')';

        if ($this->is_nullable) {
            $col .= '->nullable()';
        }

        if (!is_null($this->default_value) && $this->default_value !== '') {
            $default = is_numeric($this->default_value)
                ? $this->default_value
                : "'{$this->default_value}'";
            $col .= "->default({$default})";
        }

        $col .= ';';

        return $col;
    }
}

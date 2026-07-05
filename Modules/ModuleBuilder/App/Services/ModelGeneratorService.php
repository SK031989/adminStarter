<?php

namespace Modules\ModuleBuilder\App\Services;

use Illuminate\Support\Str;
use Modules\ModuleBuilder\App\Models\DynamicModule;

class ModelGeneratorService
{
    /**
     * Generate an Eloquent Model file for the given DynamicModule.
     */
    public function generate(DynamicModule $module): string
    {
        $className = $module->module_class_name;
        $basePath  = base_path("Modules/{$className}/App/Models");

        if (!is_dir($basePath)) {
            mkdir($basePath, 0755, true);
        }

        $filePath = "{$basePath}/{$className}.php";
        $content  = $this->buildModelContent($module);

        file_put_contents($filePath, $content);

        return $filePath;
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    private function buildModelContent(DynamicModule $module): string
    {
        $className   = $module->module_class_name;
        $tableName   = $module->table_name;
        $fillable    = $this->buildFillable($module);
        $casts       = $this->buildCasts($module);
        $scopes      = $this->buildScopes($module);

        return <<<PHP
<?php

namespace Modules\\{$className}\\App\\Models;

use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;
use Illuminate\\Database\\Eloquent\\Model;
use Illuminate\\Database\\Eloquent\\SoftDeletes;

class {$className} extends Model
{
    use HasFactory, SoftDeletes;

    protected \$table = '{$tableName}';

    protected \$fillable = [
        'tenant_id',
{$fillable}
        'status',
    ];

    protected \$casts = [
{$casts}
    ];

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeActive(\$query)
    {
        return \$query->where('status', 'active');
    }

    public function scopeForTenant(\$query, int \$tenantId)
    {
        return \$query->where('tenant_id', \$tenantId);
    }

{$scopes}
}
PHP;
    }

    private function buildFillable(DynamicModule $module): string
    {
        return $module->fields
            ->map(fn ($f) => "        '{$f->field_name}',")
            ->implode("\n");
    }

    private function buildCasts(DynamicModule $module): string
    {
        $lines = [];

        foreach ($module->fields as $field) {
            $castType = $field->type->castType();
            if ($castType !== null) {
                $lines[] = "        '{$field->field_name}' => '{$castType}',";
            }
        }

        return implode("\n", $lines);
    }

    private function buildScopes(DynamicModule $module): string
    {
        $searchable = $module->fields->where('is_searchable', true);

        if ($searchable->isEmpty()) {
            return '';
        }

        $conditions = $searchable->map(function ($field, $i) {
            $method = $i === 0 ? 'where' : 'orWhere';
            return "              ->{$method}('{$field->field_name}', 'like', \"%{\$term}%\")";
        })->implode("\n");

        return <<<PHP
    public function scopeSearch(\$query, ?string \$term)
    {
        if (blank(\$term)) {
            return \$query;
        }

        return \$query->where(function (\$q) use (\$term) {
            \$q
{$conditions};
        });
    }
PHP;
    }
}

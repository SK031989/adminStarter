<?php

namespace Modules\ModuleBuilder\App\Services;

use Illuminate\Support\Str;
use Modules\ModuleBuilder\App\Models\DynamicModule;

class MigrationGeneratorService
{
    /**
     * Generate a migration file for the given DynamicModule.
     *
     * @return string  The path to the created migration file.
     */
    public function generate(DynamicModule $module): string
    {
        $className  = $module->module_class_name;
        $tableName  = $module->table_name;
        $timestamp  = now()->format('Y_m_d_His');
        $fileName   = "{$timestamp}_create_{$tableName}_table.php";

        $migrationsPath = base_path("Modules/{$className}/database/migrations");

        if (!is_dir($migrationsPath)) {
            mkdir($migrationsPath, 0755, true);
        } else {
            // Delete any existing migrations for this table to prevent duplicates
            $existingMigrations = glob($migrationsPath . "/*_create_{$tableName}_table.php");
            if ($existingMigrations) {
                foreach ($existingMigrations as $oldFile) {
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            }
        }

        $filePath = $migrationsPath . '/' . $fileName;
        $content  = $this->buildMigrationContent($module);

        file_put_contents($filePath, $content);

        return $filePath;
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    private function buildMigrationContent(DynamicModule $module): string
    {
        $tableName    = $module->table_name;
        $columnLines  = $this->buildColumnLines($module);

        return <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('{$tableName}', function (Blueprint \$table) {
            \$table->id();
            \$table->unsignedBigInteger('tenant_id')->index();
{$columnLines}
            \$table->string('status')->default('active')->index();
            \$table->timestamps();
            \$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('{$tableName}');
    }
};
PHP;
    }

    private function buildColumnLines(DynamicModule $module): string
    {
        $lines = [];

        foreach ($module->fields as $field) {
            $lines[] = '            ' . $field->column_definition;
        }

        return implode("\n", $lines);
    }
}

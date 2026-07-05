<?php

namespace Modules\ModuleBuilder\App\Traits;

use Illuminate\Support\Str;

trait ModuleGeneratorTrait
{
    /**
     * Convert a module name to its PHP class name (StudlyCase).
     */
    public function toClassName(string $name): string
    {
        return Str::studly($name);
    }

    /**
     * Convert a module name to a snake_case plural table name.
     */
    public function toTableName(string $name): string
    {
        return Str::snake(Str::plural($name));
    }

    /**
     * Convert a module name to a kebab-case route prefix.
     */
    public function toRouteName(string $name): string
    {
        return Str::kebab(Str::plural($name));
    }

    /**
     * Ensure a directory exists, creating it recursively if needed.
     */
    protected function ensureDirectory(string $path): void
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    /**
     * Write content to a file, creating parent directories as needed.
     */
    protected function writeGeneratedFile(string $path, string $content): string
    {
        $this->ensureDirectory(dirname($path));
        file_put_contents($path, $content);
        return $path;
    }

    /**
     * Add PHP opening tag + strict types declaration.
     */
    protected function phpHeader(bool $strictTypes = true): string
    {
        $strict = $strictTypes ? "\ndeclare(strict_types=1);\n" : '';
        return "<?php{$strict}\n";
    }

    /**
     * Build a namespace line.
     */
    protected function namespaceLine(string $namespace): string
    {
        return "namespace {$namespace};\n";
    }

    /**
     * Indent a block of text by N spaces.
     */
    protected function indent(string $text, int $spaces = 4): string
    {
        $pad    = str_repeat(' ', $spaces);
        $lines  = explode("\n", $text);
        $padded = array_map(fn ($l) => $l !== '' ? $pad . $l : $l, $lines);
        return implode("\n", $padded);
    }

    /**
     * Generate a timestamp-prefixed filename for a migration.
     */
    protected function migrationFileName(string $tableName): string
    {
        return now()->format('Y_m_d_His') . "_create_{$tableName}_table.php";
    }
}

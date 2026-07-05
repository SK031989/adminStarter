<?php

namespace Modules\ModuleBuilder\App\Observers;

use Illuminate\Support\Facades\Log;
use Modules\ModuleBuilder\App\Models\DynamicModule;

class ModuleObserver
{
    /**
     * Handle the DynamicModule "created" event.
     */
    public function created(DynamicModule $module): void
    {
        Log::info("ModuleObserver: DynamicModule [{$module->name}] created (id={$module->id}).");
    }

    /**
     * Handle the DynamicModule "updated" event.
     */
    public function updated(DynamicModule $module): void
    {
        Log::info("ModuleObserver: DynamicModule [{$module->name}] updated (id={$module->id}).", [
            'dirty' => array_keys($module->getDirty()),
        ]);
    }

    /**
     * Handle the DynamicModule "deleting" event.
     * Prevent deletion if the module is already generated (safety guard).
     */
    public function deleting(DynamicModule $module): void
    {
        if ($module->is_generated) {
            Log::warning("ModuleObserver: Deleting a generated module [{$module->name}] (id={$module->id}). Consider backing up generated files.");
        }
    }

    /**
     * Handle the DynamicModule "deleted" event.
     */
    public function deleted(DynamicModule $module): void
    {
        Log::info("ModuleObserver: DynamicModule [{$module->name}] soft-deleted (id={$module->id}).");
    }

    /**
     * Handle the DynamicModule "restored" event.
     */
    public function restored(DynamicModule $module): void
    {
        Log::info("ModuleObserver: DynamicModule [{$module->name}] restored (id={$module->id}).");
    }

    /**
     * Handle the DynamicModule "force deleted" event.
     */
    public function forceDeleted(DynamicModule $module): void
    {
        Log::warning("ModuleObserver: DynamicModule [{$module->name}] permanently deleted (id={$module->id}).");
    }
}

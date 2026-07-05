<?php

namespace Modules\ModuleBuilder\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\ModuleBuilder\App\Models\DynamicModule;
use Modules\ModuleBuilder\App\Services\ModuleBuilderService;

class ModuleGenerateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Timeout in seconds.
     */
    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly DynamicModule $module) {}

    /**
     * Execute the job.
     */
    public function handle(ModuleBuilderService $service): void
    {
        Log::info("ModuleGenerateJob: starting generation for [{$this->module->name}]");

        try {
            $files = $service->generateModule($this->module);

            Log::info("ModuleGenerateJob: completed for [{$this->module->name}]", [
                'files' => array_keys($files),
            ]);
        } catch (\Throwable $e) {
            Log::error("ModuleGenerateJob: failed for [{$this->module->name}]", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::critical("ModuleGenerateJob permanently failed for [{$this->module->name}]", [
            'error' => $exception->getMessage(),
        ]);
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     *
     * @return array<int>
     */
    public function backoff(): array
    {
        return [5, 30, 60];
    }
}

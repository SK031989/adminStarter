<?php

namespace Modules\ModuleBuilder\App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\ModuleBuilder\App\Events\ModuleCreated;
use Modules\ModuleBuilder\App\Jobs\ModuleGenerateJob;

class GenerateModuleFiles implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The name of the queue the job should be sent to.
     */
    public string $queue = 'module-generation';

    /**
     * Handle the event.
     */
    public function handle(ModuleCreated $event): void
    {
        ModuleGenerateJob::dispatch($event->module)
            ->onQueue(config('modulebuilder.queue_name', 'module-generation'))
            ->onConnection(config('modulebuilder.queue_connection', 'sync'));
    }

    /**
     * Handle a job failure.
     */
    public function failed(ModuleCreated $event, \Throwable $exception): void
    {
        \Illuminate\Support\Facades\Log::error('Module generation listener failed', [
            'module' => $event->module->name,
            'error'  => $exception->getMessage(),
        ]);
    }
}

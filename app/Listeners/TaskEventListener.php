<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class TaskEventListener
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Log::info("TaskEvent Listener executed", [
            'action' => $event->action,
            'task' => $event->task,
        ]);
    }
}

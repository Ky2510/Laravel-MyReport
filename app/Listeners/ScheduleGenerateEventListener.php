<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ScheduleGenerateEventListener
{
    /**
     * Create the event listener.
     */
    public function handle(object $event): void
    {
        Log::info("ScheduleGenerateEvent Listener executed", [
            'action' => $event->action,
            'schedule_generate' => $event->schedule_generate,
        ]);
    }
}

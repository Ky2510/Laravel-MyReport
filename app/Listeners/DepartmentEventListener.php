<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class DepartmentEventListener
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Log::info("DepartmentEvent Listener executed", [
            'action' => $event->action,
            'department' => $event->department,
        ]);
    }
}

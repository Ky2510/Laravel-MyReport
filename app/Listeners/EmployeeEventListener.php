<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class EmployeeEventListener
{
    /**
     * Create the event listener.
     */
    public function handle(object $event): void
    {
        Log::info("EmployeeEvent Listener executed", [
            'action' => $event->action,
            'employee' => $event->employee,
        ]);
    }
}

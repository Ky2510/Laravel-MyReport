<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ReportEventListener
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Log::info("Report Listener executed", [
            'action' => $event->action,
            'report' => $event->report,
        ]);
    }
}

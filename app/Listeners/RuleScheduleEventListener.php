<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class RuleScheduleEventListener
{
    /**
     * Create the event listener.
     */
    public function handle(object $event): void
    {
        Log::info("RuleScheduleListener executed", [
            'action' => $event->action,
            'rule_schedule' => $event->rule_schedule,
        ]);
    }
}

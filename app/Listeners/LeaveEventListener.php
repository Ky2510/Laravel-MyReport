<?php

namespace App\Listeners;

use App\Events\LeaveEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LeaveEventListener
{
    public function handle(LeaveEvent $event)
    {
        Log::info("LeaveEvent Listener executed", [
            'action' => $event->action,
            'leave' => $event->leave,
        ]);
    }
}

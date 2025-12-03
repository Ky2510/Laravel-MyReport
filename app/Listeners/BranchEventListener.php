<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class BranchEventListener
{
    /**
     * Create the event listener.
     */
    public function handle(object $event): void
    {
        Log::info("BranchEvent Listener executed", [
            'action' => $event->action,
            'branch' => $event->branch,
        ]);
    }
}

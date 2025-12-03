<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class TitleEventListener
{

    /**
     * Create the event listener.
     */
    public function handle(object $event): void
    {
        Log::info("TitleEvent Listener executed", [
            'action' => $event->action,
            'title' => $event->title,
        ]);
    }
}

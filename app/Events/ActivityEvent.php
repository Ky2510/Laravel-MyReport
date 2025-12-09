<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ActivityEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $activity;
    public $action;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($activity, $action)
    {
        $this->activity = $activity;
        $this->action = $action;
        $this->message = "Activity berhasil di $action oleh API.";

        Log::info("ActivityEvent triggered", [
            'action' => $action,
            'activity_id' => $activity->id,
            'activity_name' => $activity->name,
            'source' => 'API'
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('activity-channel');
    }
}

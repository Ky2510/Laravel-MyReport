<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ScheduleGenerateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $scheduleGenerate;
    public $action;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($scheduleGenerate, $action)
    {
        $this->scheduleGenerate = $scheduleGenerate;
        $this->action = $action;
        $this->message = "Schedule Generate berhasil di $action oleh API.";

        Log::info("ScheduleEvent triggered", [
            'action' => $action,
            'schedule_generate_id' => $scheduleGenerate->id,
            'schedule_generate_name' => $scheduleGenerate->name,
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
        return  new Channel('schedule-generate-channel');
    }
}

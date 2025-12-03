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

class TitleEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $title;
    public $action;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($title, $action)
    {
        $this->title = $title;
        $this->action = $action;
        $this->message = "Title berhasil di $action oleh API.";

        Log::info("TitleEvent triggered", [
            'action' => $action,
            'title_id' => $title->id,
            'title_name' => $title->name,
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
        return new Channel('title-channel');
    }
}

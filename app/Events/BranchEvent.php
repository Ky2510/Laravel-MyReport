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

class BranchEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $branch;
    public $action;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($branch, $action)
    {
        $this->branch = $branch;
        $this->action = $action;
        $this->message = "Branch berhasil di $action oleh API.";

        Log::info("BranchEvent triggered", [
            'action' => $action,
            'branch_id' => $branch->id,
            'branch_name' => $branch->name,
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
        return  new Channel('branch-channel');
    }
}

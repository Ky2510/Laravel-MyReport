<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LeaveEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $leave;
    public $action;
    public $message;

    public function __construct($leave, $action)
    {
        $this->leave = $leave;
        $this->action = $action;
        $this->message = "Leave berhasil di $action oleh API.";

        Log::info("LeaveEvent triggered", [
            'action' => $action,
            'leave_id' => $leave->id,
            'leave_name' => $leave->name,
            'source' => 'API'
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('leave-channel');
    }

    public function broadcastAs()
    {
        return 'leave-event';
    }
}

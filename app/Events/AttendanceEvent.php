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

class AttendanceEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $attendance;
    public $action;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($attendance, $action)
    {
        $this->attendance = $attendance;
        $this->action = $action;
        $this->message = "Attendance berhasil di $action oleh API.";

        Log::info("AttendanceEvent triggered", [
            'action' => $action,
            'attendance_id' => $attendance->id,
            'attendance_name' => $attendance->name,
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
        return new channel('attendance-channel');
    }
}

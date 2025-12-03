<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DepartmentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $department;
    public $action;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($department, $action)
    {
        $this->department = $department;
        $this->action = $action;
        $this->message = "Department berhasil di $action oleh API.";

        Log::info("DepartmentEvent triggered", [
            'action' => $action,
            'department_id' => $department->id,
            'department_name' => $department->name,
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
        return  new Channel('department-channel');
    }
}

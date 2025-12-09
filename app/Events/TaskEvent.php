<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TaskEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $task;
    public $action;
    public $message;

    public function __construct($task, $action)
    {
        $this->task = $task;
        $this->action = $action;
        $this->message = "Task berhasil di $action oleh API.";

        Log::info("TaskEvent triggered", [
            'action' => $action,
            'task_id' => $task->id,
            'task_name' => $task->name,
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
        return new Channel('task-channel');
    }
}

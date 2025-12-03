<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EmployeeEvent implements shouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $employee;
    public $action;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($employee, $action)
    {
        $this->employee = $employee;
        $this->action = $action;
        $this->message = "Employee berhasil di $action oleh API.";

        Log::info("EmployeeEvent triggered", [
            'action' => $action,
            'employee_id' => $employee->id,
            'employee_name' => $employee->name,
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
        return new channel('employee-channel');
    }
}

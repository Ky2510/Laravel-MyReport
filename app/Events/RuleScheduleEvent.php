<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RuleScheduleEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $rule_schedule;
    public $action;
    public $message;
    /**
     * Create a new event instance.
     */
    public function __construct($rule_schedule, $action)
    {
        $this->rule_schedule = $rule_schedule;
        $this->action = $action;
        $this->message = "Rule Schedule berhasil di $action oleh API.";

        Log::info("BranchEvent triggered", [
            'action' => $action,
            'rule_schedule_id' => $rule_schedule->id,
            'rule_schedule_name' => $rule_schedule->name,
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
        return new channel('rule-schedule-channel');
    }
}

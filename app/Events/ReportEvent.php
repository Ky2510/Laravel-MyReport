<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ReportEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $report;
    public $action;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($report, $action)
    {
        $this->report = $report;
        $this->action = $action;
        $this->message = "Report berhasil di $action oleh API.";


        Log::info("ReportEvent triggered", [
            'action' => $action,
            'report_id' => $report->id,
            'report_name' => $report->name,
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
        return new Channel('report-channel');
    }

    public function broadcastAs()
    {
        return 'report-event';
    }
}

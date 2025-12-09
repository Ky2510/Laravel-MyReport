<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityPlanEstimateTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'priority' => $this->priority,
            'progress' => $this->progress,
            'schedule' => $this->schedule,
            'status' => $this->status,
        ];
    }
}

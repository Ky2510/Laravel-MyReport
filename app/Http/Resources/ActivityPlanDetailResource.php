<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityPlanDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'budget' => $this->budget,
            'estimated_duration' => $this->estimated_duration,
            'attachment' => $this->attachment,
            'notes' => $this->notes,
            'required_resources' => $this->required_resources,
            'risk_level' => $this->risk_level,
            'outcome_expected' => $this->outcome_expected,
            'success_criteria' => $this->success_criteria,
            'dependencies' => $this->dependencies,
            'stakeholders' => $this->stakeholders,
            'tasks' => $this->tasks,
        ];
    }
}

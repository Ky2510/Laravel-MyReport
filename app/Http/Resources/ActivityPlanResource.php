<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'activityPlanId' => $this->activityPlanId,
            'userId' => $this->userId,
            'department_id' => $this->department_id,
            'title'          => $this->title,
            'description'    => $this->description,
            'category'       => $this->category,
            'createBy' => $this->user->name
        ];
    }
}

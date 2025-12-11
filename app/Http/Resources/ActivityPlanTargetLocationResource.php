<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityPlanTargetLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'targetOutlet' => $this->outlet,
            'reason' => $this->reason,
            'teamMembers' => $this->team_members->map(function ($member) {
                return [
                    'id' => $member->id,
                    'user_id' => $member->id_user,
                    'nama' => $member->user_core?->nama,
                    'email' => $member->user_core?->email,
                    'area_name' => $member->user_core?->areas?->map(fn($a) => $a->area_name),
                ];
            }),

            'targetPerson' => $this->targetPerson,
            'latitude' => $this->latitude
        ];
    }
}

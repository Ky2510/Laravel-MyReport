<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'employee_name' => $this->employee->name ?? null,
            'department_name' => $this->employee->department->name ?? null,
            'date_check' => $this->date_check,
            'time_check' => $this->time_check,
            'check_type' => $this->check_type,
            'status' => $this->status,
        ];
    }
}

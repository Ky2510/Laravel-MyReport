<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait EmployeeQueryScope
{
    public function scopeFuncEmployeeSearch(Builder $query, $search = null)
    {
        return $query->with('department', 'branch', 'ruleSchedule', 'scheduleGenerate', 'title')->where('status', true)
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->latest();
    }
}

<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ScheduleGenerateQueryScope
{
    public function scopeFuncScheduleGenerateSearch(Builder $query, $search = null)
    {
        return $query->with('ruleSchedule', 'employee')->when($search != null, function ($query) use ($search) {
            $query->where('date_check', 'like', '%' . $search . '%');
        })->latest();
    }
}

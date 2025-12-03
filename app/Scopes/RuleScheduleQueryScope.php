<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait RuleScheduleQueryScope
{
    public function scopeFuncRuleScheduleSearch(Builder $query, $search = null)
    {
        return $query->with('department')->when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->latest();
    }
}

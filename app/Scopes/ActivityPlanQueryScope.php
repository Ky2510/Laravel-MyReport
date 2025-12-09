<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ActivityPlanQueryScope
{
    public function scopeFuncActivityPlanSearch(Builder $query, $search = null)
    {
        return $query->with('user')->when($search, function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%");
        })->latest();
    }
}

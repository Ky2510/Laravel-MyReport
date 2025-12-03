<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait LeaveQueryScope
{
    public function scopeFunceLeaveSearch(Builder $query, $search = null)
    {
        return $query->where('active', true)->when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->latest();
    }
}

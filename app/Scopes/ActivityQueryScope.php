<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ActivityQueryScope
{
    public function scopeFuncActivitySearch(Builder $query, $search = null)
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where('id', 'like', "%{$search}%");
        })->orderBy('area_name', 'asc');
    }
}

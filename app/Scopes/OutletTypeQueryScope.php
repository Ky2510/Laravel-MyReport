<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait OutletTypeQueryScope
{
    public function scopeFuncOutletTypeSearch(Builder $query, $search = null)
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->latest();
    }
}

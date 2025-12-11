<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait OutletQueryScope
{
    public function scopeFuncOutletSearch(Builder $query, $search = null)
    {
        return $query->with('area.members.staff')->with('outletType')->when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->latest();
    }
}

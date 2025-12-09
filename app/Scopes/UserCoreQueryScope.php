<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait UserCoreQueryScope
{
    /**
     * Scope untuk joinb employee, filter check_type, dan search.
     */

    public function scopeFuncUserCoreSearch(Builder $query, $search = null)
    {

        return $query->with('areas')->when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->orderBy('nama', 'asc');;
    }
}

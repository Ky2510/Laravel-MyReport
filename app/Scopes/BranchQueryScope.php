<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait BranchQueryScope
{
    /**
     * Scope untuk join employee, filter check_type, dan search.
     */
    public function scopeFuncBranchSearch(Builder $query, $search = null)
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->orderBy('created_at', 'DESC');
    }
}

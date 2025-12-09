<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait TeamMemberQueryScope
{
    /**
     * Scope untuk joinb employee, filter check_type, dan search.
     */
    public function scopeFuncTeamMemberSearch(Builder $query, $search = null)
    {
        return $query->with('activityPlan', 'user_core')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->latest();
    }
}

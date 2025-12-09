<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait TaskQueryScope
{
    /**
     * Scope untuk joinb employee, filter check_type, dan search.
     */

    public function scopeFuncTaskSearch(Builder $query, $search = null)
    {
        $user = auth()->user();

        return $query->with('activityPlan', 'user')
            ->when($user && $user->role !== 'super_admin', function ($q) use ($user) {
                $q->where('id_user', $user->id);
            })->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->latest();
    }
}

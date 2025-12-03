<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait DepartmentQueryScope
{
    /**
     * Scope untuk join employee, filter check_type, dan search.
     */
    public function scopeFuncDepartmentByStatus(Builder $query, $search = null)
    {
        return $query->where('status', true)
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'DESC');
    }
}

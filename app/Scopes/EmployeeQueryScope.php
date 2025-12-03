<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait EmployeeQueryScope
{
    public function scopeFuncEmployeeSearch(Builder $query, $search = null)
    {
        return $query->where('status', true)
            ->when($search, function ($q) use ($search) {
                $q->where('id_number', 'like', "%{$search}%");
            })->latest();
    }
}

<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait LeaveDaysQueryScope
{
    public function scopeFuncLeaveDaysSearch(Builder $query, $search = null)
    {
        return $query->with('employee', 'leave', 'report')
            ->when($search != null, function ($q) use ($search) {
                $q->where('employees.name', 'like', '%' . $search . '%');
            })->latest();
    }
}

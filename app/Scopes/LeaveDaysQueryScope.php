<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait LeaveDaysQueryScope
{
    public function funcLeaveDaysSearch(Builder $query, $search = null)
    {
        return $query->when($search != null, function ($q) use ($search) {
            $q->where('id', 'like', '%' . $search . '%');
        })->latest();
    }
}

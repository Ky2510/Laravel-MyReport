<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait TitleQueryScope
{
    public function scopeFuncTitleSearch(Builder $query, $search = null)
    {
        return $query->where('status', true)->when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->latest();
    }
}

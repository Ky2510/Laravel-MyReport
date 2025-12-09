<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait DocumentFileQueryScope
{
    /**
     * Scope untuk joinb employee, filter check_type, dan search.
     */
    public function scopeFuncDocumentFileSearch(Builder $query, $search = null)
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where('filename', 'like', "%{$search}%");
        })->latest();
    }
}

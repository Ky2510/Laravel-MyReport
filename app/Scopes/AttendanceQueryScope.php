<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait AttendanceQueryScope
{
    public function scopeFuncAttendanceSearch(Builder $query, $search = null)
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where('serial_number', 'like', "%{$search}%");
        })->orderBy('created_at', 'DESC');
    }
}

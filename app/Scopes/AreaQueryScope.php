<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait AreaQueryScope
{
    /**
     * Scope untuk joinb employee, filter check_type, dan search.
     */

    public function scopeFuncAreaSearch(Builder $query, $search = null)
    {
        return $query->with(['members.staff'])->when($search, function ($q) use ($search) {
            $q->where('area_name', 'like', "%{$search}%");
        })->orderBy('area_name', 'asc');
    }


    public function scopeMembersByArea(Builder $query, $area)
    {
        return $query
            ->with(['staff', 'area'])
            ->whereHas('area', function ($q) use ($area) {

                // area_id (PRIMARY KEY)
                $q->where('area_id', $area)

                    // cari berdasarkan nama area
                    ->orWhere('area_name', 'like', "%{$area}%");
            });
    }
}

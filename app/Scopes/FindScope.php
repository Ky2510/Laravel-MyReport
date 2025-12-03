<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait FindScope
{
    /**
     * Scope untuk mencari berdasarkan kolom dinamis.
     *
     * @param Builder $query
     * @param string $column
     * @param mixed $value
     * @return Builder
     */
    public function scopeFindBy(Builder $query, string $column, $value)
    {
        return $query->where($column, $value);
    }
}

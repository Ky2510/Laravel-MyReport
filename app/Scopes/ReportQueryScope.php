<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ReportQueryScope
{
    /**
     * Scope untuk join employee, filter check_type, dan search.
     */
    public function scopeFuncReportEmployee(Builder $query, $checkType, $search = null)
    {
        return $query->with('employee')
            ->join('employees', 'employees.id', '=', 'reports.employee_id')
            ->when($search != null, function ($q) use ($search) {
                $q->where('employees.name', 'like', '%' . $search . '%');
            })
            ->orderBy('reports.date_check', 'desc')
            ->orderBy('reports.time_check', 'desc')
            ->select('reports.*');
    }

    public function scopeFuncReportEmployeeByCheckType(Builder $query, $checkType, $search = null)
    {
        return $query->where('check_type', $checkType)->with('employee')
            ->join('employees', 'employees.id', '=', 'reports.employee_id')
            ->when($search != null, function ($q) use ($search) {
                $q->where('employees.name', 'like', '%' . $search . '%');
            })
            ->orderBy('reports.date_check', 'desc')
            ->orderBy('reports.time_check', 'desc')
            ->select(
                'reports.*',
            );
    }

    public function scopeFuncReportEmployeeByStatus(Builder $query, $status, $search = null)
    {
        return $query->where('reports.status', $status)->with('employee')
            ->join('employees', 'employees.id', '=', 'reports.employee_id')
            ->when($search != null, function ($q) use ($search) {
                $q->where('employees.name', 'like', '%' . $search . '%');
            })
            ->orderBy('reports.date_check', 'desc')
            ->orderBy('reports.time_check', 'desc')
            ->select(
                'reports.*',
            );
    }
}

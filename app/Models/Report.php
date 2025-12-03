<?php

namespace App\Models;

use App\Scopes\FindScope;
use App\Scopes\ReportQueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Report extends Model
{
    use HasFactory, ReportQueryScope, FindScope;

    protected $table = 'reports';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'date_check',
        'time_check',
        'temperature',
        'max_att',
        'late_minutes',
        'overtime_minutes',
        'check_type',
        'status'
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}

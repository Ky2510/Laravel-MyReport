<?php

namespace App\Models;

use App\Scopes\FindScope;
use App\Scopes\LeaveDaysQueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LeaveDays extends Model
{
    use HasFactory, LeaveDaysQueryScope, FindScope;

    protected $table = 'leave_days';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'leave_id',
        'report_id',
        'substitute_id',
        'start_date',
        'end_date',
        'days',
        'description',
        'file_url',
        'approved'
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

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id', 'id');
    }

    public function leave()
    {
        return $this->belongsTo(Leave::class, 'leave_id', 'id');
    }
}

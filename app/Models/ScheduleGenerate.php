<?php

namespace App\Models;

use App\Scopes\FindScope;
use App\Scopes\ScheduleGenerateQueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ScheduleGenerate extends Model
{
    use HasFactory, ScheduleGenerateQueryScope, FindScope;

    protected $table = 'schedule_generates';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'rule_schedule_id',
        'date_check',
        'time_check',
        'type'
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

    public function ruleSchedule()
    {
        return $this->belongsTo(RuleSchedule::class, 'rule_schedule_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}

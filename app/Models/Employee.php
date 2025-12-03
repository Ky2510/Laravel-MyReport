<?php

namespace App\Models;

use App\Scopes\EmployeeQueryScope;
use App\Scopes\FindScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory, EmployeeQueryScope, FindScope;

    protected $table = 'employees';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'email',
        'npwp',
        'id_number',
        'badge_number',
        'department_id',
        'title_id',
        'address',
        'gender',
        'phone_number',
        'since',
        'rule_schedule_id',
        'status',
        'added_as_user',
        'id_vanue',
        'machine_id',
        'personal_id',
        'last_education',
        'martial_status',
        'end_working',
        'branch_id',
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

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function ruleSchedule()
    {
        return $this->belongsTo(RuleSchedule::class, 'rule_schedules_id');
    }

    public function scheduleGenerate()
    {
        return $this->hasMany(ScheduleGenerate::class, 'rule_schedules_id');
    }

    public function title()
    {
        return $this->belongsTo(Title::class, 'title_id');
    }
}

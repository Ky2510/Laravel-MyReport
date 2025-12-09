<?php

namespace App\Models;

use App\Scopes\ActivityPlanQueryScope;
use App\Scopes\FindScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ActivtyPlan extends Model
{
    use HasFactory, ActivityPlanQueryScope, FindScope;

    protected $table = 'activity_plans';

    protected $primaryKey = 'activityPlanId';

    public $incrementing = false;

    protected $keyType = 'string';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'userId',
        'department_id',
        'title',
        'description',
        'startDate',
        'endDate',
        'priority',
        'progress',
        'tasks',
        'category',
        'budget',
        'estimated_duration',
        'attachment',
        'notes',
        'required_resources',
        'risk_level',
        'outcome_expected',
        'success_criteria',
        'dependencies',
        'stakeholders',
        'createBy',
        'updateBy',
        'schedule',
        'targetOutlet',
        'reason',
        'teamMembers',
        'targetPerson',
        'latitude',
        'longitude',
        'target_location',
        'status',
        'createdAt',
        'updatedAt',
    ];

    protected $casts = [
        'tasks' => 'array',
        'stakeholders' => 'array',
        'success_criteria' => 'array',
        'dependencies' => 'array',
        'required_resources' => 'array',
        'outcome_expected' => 'array',
        'notes' => 'string',
        'progress' => 'integer',
        'budget' => 'decimal:2',
        'estimated_duration' => 'integer',
        'startDate' => 'date',
        'endDate' => 'date',
        'schedule' => 'datetime',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
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

    public function tasks()
    {
        return $this->hasMany(Task::class, 'id_activity_plan', 'activityPlanId');
    }


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }


    public function team_members()
    {
        return $this->hasMany(TeamMember::class, 'id_activity_plan', 'activityPlanId')->with('user_core');
    }


    public function calculateProgress()
    {
        $total = $this->tasks()->count();

        if ($total == 0) {
            return 0;
        }

        $done = $this->tasks()->where('status', 'done')->count();

        return round(($done / $total) * 100);
    }
}

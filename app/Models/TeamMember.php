<?php

namespace App\Models;

use App\Scopes\FindScope;
use App\Scopes\TeamMemberQueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TeamMember extends Model
{
    use HasFactory, TeamMemberQueryScope, FindScope;

    protected $table = 'team_members';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_activity_plan',
        'id_user',
    ];

    protected $casts = [
        'state' => 'boolean',
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

    public function activityPlan()
    {
        return $this->belongsTo(ActivtyPlan::class, 'id_activity_plan', 'activityPlanId');
    }

    public function user_core()
    {
        return $this->belongsTo(UserCore::class, 'id_user', 'id');
    }
}

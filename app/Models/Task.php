<?php

namespace App\Models;

use App\Scopes\FindScope;
use App\Scopes\TaskQueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory, TaskQueryScope, FindScope;

    protected $table = 'tasks';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'id_user',
        'id_activity_plan',
        'status'
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

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}

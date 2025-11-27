<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RuleSchedule extends Model
{
    use HasFactory;

    protected $table = 'rule_schedules';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'check_in',
        'check_out',
        'overtime_after',
        'max_after',
        'max_att',
        'department_id',
        'is_shift'
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

    public function employees()
    {
        return $this->hasMany(Employee::class, 'rule_schedule_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}

<?php

namespace App\Models;

use App\Scopes\DepartmentQueryScope;
use App\Scopes\FindScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Department extends Model
{
    use HasFactory, DepartmentQueryScope, FindScope;

    protected $table = 'departments';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'status',
        'activate_notif'
    ];

    protected $attributes = [
        'status' => true,
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


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'id');
    }
}

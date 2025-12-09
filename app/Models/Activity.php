<?php

namespace App\Models;

use App\Scopes\ActivityQueryScope;
use App\Scopes\FindScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasFactory, ActivityQueryScope, FindScope;

    protected $table = 'activities';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'hospital_name',
        'person_name',
        'occupation',
        'notes',
        'date',
        'latitude',
        'longitude',
        'created_at',
        'updated_at'
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
}

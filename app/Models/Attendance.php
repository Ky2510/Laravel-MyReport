<?php

namespace App\Models;

use App\Scopes\AttendanceQueryScope;
use App\Scopes\FindScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Attendance extends Model
{
    use HasFactory, AttendanceQueryScope, FindScope;

    protected $table = 'attendances';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'image_url',
        'badge_number',
        'date_check',
        'time_check',
        'check_type',
        'temperature',
        'serial_number',
        'is_guest',
        'is_from_mobile',
        'mobile_name',
        'latitude',
        'latitude',
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

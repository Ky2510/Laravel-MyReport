<?php

namespace App\Models;

use App\Scopes\FindScope;
use App\Scopes\LeaveQueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Leave extends Model
{
    use HasFactory, LeaveQueryScope, FindScope;

    protected $table = 'leaves';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'days',
        'description',
        'is_main',
        'is_cut_main',
        'is_pay',
        'required_document',
        'active'
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'is_cut_main' => 'boolean',
        'is_pay' => 'boolean',
        'required_document' => 'boolean',
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

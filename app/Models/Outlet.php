<?php

namespace App\Models;

use App\Scopes\FindScope;
use App\Scopes\OutletQueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Outlet extends Model
{
    use HasFactory, OutletQueryScope, FindScope;

    protected $table = 'outlets';

    protected $primaryKey = 'outletId';

    public $incrementing = false;

    protected $keyType = 'string';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'outletId',
        'code',
        'name',
        'type',
        'address',
        'city',
        'province',
        'phone',
        'email',
        'area',
        'createdAt',
        'updatedAt',
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

    public function area()
    {
        return $this->belongsTo(Area::class, 'area', 'area_id');
    }

    public function outletType()
    {
        return $this->belongsTo(OutletType::class, 'type', 'id');
    }
}

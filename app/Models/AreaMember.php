<?php

namespace App\Models;

use App\Scopes\AreaQueryScope;
use App\Scopes\FindScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AreaMember extends Model
{
    use HasFactory, AreaQueryScope, FindScope;

    protected $table = 'gart_area_member';

    protected $primaryKey = 'area_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';


    protected $fillable = [
        'area_id',
        'staff_id'
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
        return $this->belongsTo(Area::class, 'area_id', 'area_id');
    }

    public function staff()
    {
        return $this->belongsTo(UserCore::class, 'staff_id', 'id');
    }
}

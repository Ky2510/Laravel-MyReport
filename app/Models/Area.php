<?php

namespace App\Models;

use App\Scopes\AreaQueryScope;
use App\Scopes\FindScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Area extends Model
{
    use HasFactory, AreaQueryScope, FindScope;

    protected $table = 'gart_area';

    protected $primaryKey = 'area_id';

    public $timestamps = false;


    public $incrementing = true;


    protected $keyType = 'int';


    protected $fillable = [
        'area_id',
        'area_name',
        'area_manager_id',
        'bc_number_coa',
        'bc_name_coa'
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
    public function members()
    {
        return $this->hasMany(AreaMember::class, 'area_id', 'area_id');
    }


    public function users()
    {
        return $this->belongsToMany(
            UserCore::class,
            'gart_area_member',
            'area_id',
            'staff_id'
        );
    }
}

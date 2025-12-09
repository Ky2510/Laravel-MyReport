<?php

namespace App\Models;

use App\Scopes\FindScope;
use App\Scopes\UserCoreQueryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserCore extends Model
{
    use HasFactory, UserCoreQueryScope, FindScope;

    protected $table = 'tbl_user';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'jab_id',
        'password',
        'email',
        'nama',
        'first_name',
        'last_name',
        'telp',
        'kode_nama',
        'aktif',
        'remember_token'
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

    public function area_members()
    {
        return $this->hasMany(AreaMember::class, 'staff_id', 'id');
    }


    public function areas()
    {
        return $this->belongsToMany(
            Area::class,
            'gart_area_member',
            'staff_id',
            'area_id'
        );
    }
}

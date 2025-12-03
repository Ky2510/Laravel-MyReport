<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    use HasFactory;

    protected $table = 'submenus';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';


    protected $fillable = [
        'menuId',
        'name',
        'icon',
        'url',
        'numberOrder',
        'state',
        'createBy',
        'updatedBy'
    ];
}

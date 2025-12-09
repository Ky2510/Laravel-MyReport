<?php

namespace App\Models;

use App\Scopes\DocumentFileQueryScope;
use App\Scopes\FindScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DocumentFile extends Model
{
    use HasFactory, DocumentFileQueryScope, FindScope;

    protected $table = 'document_files';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'ref_id',
        'filename',
        'fileurl',
        'state'
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
}

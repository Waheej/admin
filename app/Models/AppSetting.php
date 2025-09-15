<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppSetting extends Model
{
    use SoftDeletes;

    /**
     * The name of the relation for file attachments.
     */
    public const FILE_RELATION_NAME = "attachments";

    /**
     * The upload path for Industry files.
     */
    public const FILE_UPLOAD_PATH = 'app_settings';

    protected $fillable = [
        'key',
        'title_en',
        'title_ar',
        'value',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}

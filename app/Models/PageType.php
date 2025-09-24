<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageType extends Model
{
    use SoftDeletes;

    /**
     * The name of the relation for file attachments.
     */
    public const FILE_RELATION_NAME = "attachments";

    /**
     * The upload path for partners_and_subsidiaries files.
     */
    public const FILE_UPLOAD_PATH = 'page_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title_en',
        'title_ar',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [];
}

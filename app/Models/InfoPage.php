<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfoPage extends Model
{
    use SoftDeletes;

    /**
     * The name of the relation for file attachments.
     */
    public const FILE_RELATION_NAME = "attachments";

    /**
     * The upload path for info_pages files.
     */
    public const FILE_UPLOAD_PATH = 'info_pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'type',
        'order',
        'is_active',
        'project_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['media_path'];

    /**
     * Get the media_path attribute.
     *
     * @param string $value The original media_path.
     * @return string|null The media_path attribute.
     */
    public function getMediaPathAttribute($value): string |null
    {
        $record = File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'media_path')
            ->where('fileable_type', self::class)
            ->where('fileable_id', $this->id)
            ->whereIsActive(true)
            ->first();

        return $record ?  $record->file_name : null;
    }

    /**
     * Get the attachments associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function attachments(): MorphOne
    {
        return $this->morphOne(File::class, "fileable");
    }

    /**
     * Get the project associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}

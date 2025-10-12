<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomePageSection extends Model
{
    use SoftDeletes;

    /**
     * The name of the relation for file attachments.
     */
    public const FILE_RELATION_NAME = "attachments";

    /**
     * The upload path for partners_and_subsidiaries files.
     */
    public const FILE_UPLOAD_PATH = 'page_sections';

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
        'type', // hero, featured_projects, news, map, stats, testimonials, cta, newsletter
        'page_type_id',
        'order',
        'is_active',
        'additional_data',
        'project_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'media',
        'mobile_media',
        'videos'
    ];



    /**
     * Get the media attribute.
     *
     * @param string $value The original media.
     * @return string|null The media attribute.
     */
    public function getMediaAttribute($value): array | null
    {
        return File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'media')
            ->where('fileable_type', self::class)
            ->where('fileable_id', $this->id)
            ->where('is_active', true)
            ->get()
            ->pluck('file_name')
            ->toArray();
    }

    /**
     * Get the mobile_media attribute.
     *
     * @param string $value The original mobile_media.
     * @return string|null The mobile_media attribute.
     */
    public function getMobileMediaAttribute($value): array | null
    {
        return File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'mobile_media')
            ->where('fileable_type', self::class)
            ->where('fileable_id', $this->id)
            ->where('is_active', true)
            ->get()
            ->pluck('file_name')
            ->toArray();
    }

    /**
     * Get the videos attribute.
     *
     * @param string $value The original videos.
     * @return string|null The videos attribute.
     */

    public function getVideosAttribute($value): array | null
    {
        return File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'videos')
            ->where('fileable_type', self::class)
            ->where('fileable_id', $this->id)
            ->where('is_active', true)
            ->get()
            ->pluck('file_name')
            ->toArray();
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

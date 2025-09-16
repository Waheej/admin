<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        'order',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['media'];

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
     * Get the attachments associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function attachments(): MorphOne
    {
        return $this->morphOne(File::class, "fileable");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SEO extends Model
{
    use SoftDeletes;

    /**
     * The name of the relation for file attachments.
     */
    public const FILE_RELATION_NAME = "attachments";

    /**
     * The upload path for Industry files.I
     */
    public const FILE_UPLOAD_PATH = 'seo';


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
        'keywords_en',
        'keywords_ar',
        'url',
        'og_title_en',
        'og_title_ar',
        'og_description_en',
        'og_description_ar',
        'og_url',
        'twitter_title_en',
        'twitter_title_ar',
        'twitter_description_en',
        'twitter_description_ar',
        'twitter_url',
        'canonical_url',
        'robots',
        'page', //enum 
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['image', 'og_image', 'twitter_image'];

    protected $casts = [
        'keywords_en' => AsArrayObject::class,
        'keywords_ar' => AsArrayObject::class,
    ];

    /**
     * Get the image attribute.
     *
     * @param string $value The original image.
     * @return string|null The image attribute.
     */
    public function getImageAttribute($value): string |null
    {
        $record = File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'image')
            ->where('fileable_type', self::class)
            ->where('fileable_id', $this->id)
            ->whereIsActive(true)
            ->first();

        return $record ?  $record->file_name : null;
    }

    /**
     * Get the og_image attribute.
     *
     * @param string $value The original og_image.
     * @return string|null The og_image attribute.
     */
    public function getOgImageAttribute($value): string |null
    {
        $record = File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'og_image')
            ->where('fileable_type', self::class)
            ->where('fileable_id', $this->id)
            ->whereIsActive(true)
            ->first();

        return $record ?  $record->file_name : null;
    }

    /**
     * Get the twitter_image attribute.
     *
     * @param string $value The original twitter_image.
     * @return string|null The twitter_image attribute.
     */    public function getTwitterImageAttribute($value): string |null
    {
        $record = File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'twitter_image')
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
}

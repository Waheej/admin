<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    /**
     * The name of the relation for file attachments.
     */
    public const FILE_RELATION_NAME = "attachments";

    /**
     * The upload path for Industry files.I
     */
    public const FILE_UPLOAD_PATH = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'status',
        'lat',
        'long',
        'price',
        'city',
        'apartment_type',
        'parent_id',
        'is_active',
        'order',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'map',
        'image',
        'image_mobile',
        'video',
        'rendered_images',
        'rendered_images_mobile',
    ];

    /**
     * Get the map attribute.
     *
     * @param string $value The original map.
     * @return string|null The map attribute.
     */
    public function getMapAttribute($value): string |null
    {
        $record = File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'map')
            ->where('fileable_type', self::class)
            ->where('fileable_id', $this->id)
            ->whereIsActive(true)
            ->first();

        return $record ? $record->file_name : null;
    }

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

        return $record ? $record->file_name : null;
    }

    /**
     * Get the image_mobile attribute.
     *
     * @param string $value The original image_mobile.
     * @return string|null The image_mobile attribute.
     */
    public function getImageMobileAttribute($value): string |null
    {
        $record = File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'image_mobile')
            ->where('fileable_type', self::class)
            ->where('fileable_id', $this->id)
            ->whereIsActive(true)
            ->first();
        return $record ? $record->file_name : null;
    }

    /**
     * Get the video attribute.
     *
     * @param string $value The original video.
     * @return string|null The video attribute.
     */
    public function getVideoAttribute($value): string |null
    {
        $record = File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'video')
            ->where('fileable_type', self::class)
            ->where('fileable_id', $this->id)
            ->whereIsActive(true)
            ->first();
        return $record ? $record->file_name : null;
    }

    /**
     * Get the rendered_images attribute.
     *
     * @param string $value The original rendered_images.
     * @return string|null The rendered_images attribute.
     */
    public function getRenderedImagesAttribute($value): array | null
    {
        return File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'rendered_images')
            ->where('fileable_type', self::class)
            ->where('fileable_id', $this->id)
            ->where('is_active', true)
            ->get()
            ->pluck('file_name')
            ->toArray();
    }

    /**
     * Get the rendered_images_mobile attribute.
     *
     * @param string $value The original rendered_images_mobile.
     * @return string|null The rendered_images_mobile attribute.
     */
    public function getRenderedImagesMobileAttribute($value): array | null
    {
        return File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'rendered_images_mobile')
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
     * Get the parent project of the current project.
     */
    public function parent()
    {
        return $this->belongsTo(Project::class, 'parent_id');
    }

    /**
     * Get the child projects of the current project.
     */
    public function children()
    {
        return $this->hasMany(Project::class, 'parent_id', 'id')->where('is_active', true);
    }

    /**
     * Get the info pages associated with the project.
     */
    public function news()
    {
        return $this->hasMany(InfoPage::class, 'project_id')
            ->where('type', 'news')
            ->where('is_active', true)
            ->orderBy('order', 'ASC');
    }
}

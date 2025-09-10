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
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['map'];

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
     * Get the attachments associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function attachments(): MorphOne
    {
        return $this->morphOne(File::class, "fileable");
    }
}

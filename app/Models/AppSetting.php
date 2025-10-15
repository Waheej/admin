<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
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

    protected $appends = ['Icon'];

    /**
     * Get the icon attribute.
     *
     * @param string $value The original icon.
     * @return string|null The icon attribute.
     */
    public function getIconAttribute($value): string |null
    {
        $record = File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'icon')
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

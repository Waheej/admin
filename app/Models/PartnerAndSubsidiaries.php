<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerAndSubsidiaries extends Model
{
    use SoftDeletes;

    /**
     * The name of the relation for file attachments.
     */
    public const FILE_RELATION_NAME = "attachments";

    /**
     * The upload path for partners_and_subsidiaries files.
     */
    public const FILE_UPLOAD_PATH = 'partners_and_subsidiaries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'type', // 'partner' or 'subsidiary'
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['img'];

    /**
     * Get the img attribute.
     *
     * @param string $value The original img.
     * @return string|null The img attribute.
     */
    public function getImgAttribute($value): string |null
    {
        $record = File::where('folder', self::FILE_UPLOAD_PATH)
            ->where('label', 'img')
            ->where('fileable_type', self::class)
            ->where('fileable_id', $this->id)
            ->whereIsActive(true)
            ->first();

        return $record ? env('APP_URL') . '/storage/' . $record->file_name : null;
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

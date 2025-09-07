<?php

namespace App\Models;

use App\Enums\GeneralEnums;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file_name',
        'fileable_type',
        'fileable_id',
        'file_type',
        'folder',
        'notes',
        'label',
        'order',
        'file_size',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getIsActiveAttribute($value): bool
    {
        return $value == 1 ? true : false;
    }

    /**
     * Get the file name attribute.
     *
     * @param string $value The original file name.
     * @return string|null The file name attribute.
     */
    public function getFileNameAttribute($value): string | null
    {
        // Construct the path to check.
        $checkPath = $this->folder . '/' . $value;
        // Get the filesystem disk from the environment.
        $filesystemDisk = env('FILESYSTEM_DISK', 'local');
        // Check if the file exists in the storage.
        if (Storage::disk($filesystemDisk)->exists('public/' . $checkPath)) {
            if (env('APP_ENV') == 'local') {
                return $checkPath;
            }
            return env('APP_URL') . Storage::disk($filesystemDisk)->url($checkPath);
        }
        // If the file does not exist, return null.
        return null;
    }

    public function getFileTypeAttribute($value): string | null
    {
        return GeneralEnums::FileTypes[strtolower($value)];
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}

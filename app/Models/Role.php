<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'roles';

    /**
     * The upload path for Industry files.
     */
    public const FILE_UPLOAD_PATH = 'roles';

    /**
     * The base url for this model routes
     */
    public const BASEURL = 'roles';

    protected $fillable = [
        'title_en',
        'title_ar',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the permissions associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}

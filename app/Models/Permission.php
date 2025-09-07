<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'permissions';

    /**
     * The upload path for Industry files.I
     */
    public const FILE_UPLOAD_PATH = 'permissions';

    /**
     * The base url for this model routes
     */
    public const BASEURL = 'permissions';

    protected $fillable = [
        'permission',
        'title_en',
        'title_ar',
        'group', //related model 
        'route',
    ];

    /**
     * Get the users associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

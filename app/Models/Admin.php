<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use SoftDeletes, Notifiable;
    protected $connection = "mysql";

    /**
     * The name of the relation for file attachments.
     */
    public const FILE_RELATION_NAME = "attachments";

    /**
     * The upload path for Industry files.I
     */
    public const FILE_UPLOAD_PATH = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'country_code',
        'mobile',
        'password',
        'locale',
        'is_active',
        'role_id',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the permissions associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user', 'user_id', 'permission_id');
    }

    /**
     * Get the role associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}

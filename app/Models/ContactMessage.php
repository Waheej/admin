<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use SoftDeletes;
    /**
     * The name of the relation for file attachments.
     */
    public const FILE_RELATION_NAME = "attachments";

    /**
     * The upload path for contact message files.
     */
    public const FILE_UPLOAD_PATH = 'contact_messages';

    protected $fillable = [
        'name',
        'country_code',
        'mobile',
        'email',
        'message',
        'status',
        'project_id'
    ];

    /**
     * Get the project associated with this contact message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;

class Comment extends Model
{
    use HasFactory;

    protected $casts = ['properties' => 'collection'];
    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(fn(Comment $comment) =>
            Activity::where('subject_type', get_called_class())
                ->where('subject_id', $comment->id)
                ->delete()
        );
    }

    /**
     * Get the parent commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user that added this comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

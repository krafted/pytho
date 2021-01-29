<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $casts = ['properties' => 'collection'];
    protected $guarded = [];

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

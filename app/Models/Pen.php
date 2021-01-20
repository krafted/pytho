<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pen extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'title', 'content', 'description', 'visibility',
    ];

    /**
     * Get the user that owns the Pen.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the path to the Pen.
     */
    public function path()
    {
        return route('pen.show', $this->slug);
    }
}

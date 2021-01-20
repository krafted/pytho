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
     * Get the user that owns the pen.
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function path()
    {
        return route('pen.show', $this->slug);
    }
}

<?php

namespace App\Models;

use App\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Pen extends Model
{
    use HasComments;
    use HasFactory;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'title', 'content', 'description', 'visibility',
    ];

    protected static $logFillable = true;
    protected static $logName = 'pens';
    protected static $logOnlyDirty = true;
    protected static $recordEvents = ['created', 'updated'];

    /**
     * Scope a query to only include public pens.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Support\Str                $visibility
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfVisibility($query, $visibility)
    {
        return $query->where('visibility', $visibility);
    }

    /**
     * Get the user that owns the Pen.
     */
    public function creator()
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

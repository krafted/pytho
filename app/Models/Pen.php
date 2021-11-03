<?php

namespace App\Models;

use App\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Pen extends Model
{
    use HasComments;
    use HasFactory;
    use LogsActivity;
    use Searchable;

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

    protected static function booted()
    {
        static::deleting(fn(Pen $pen) =>
            Activity::where('subject_type', get_called_class())
                ->where('subject_id', $pen->id)
                ->delete()
        );
    }

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

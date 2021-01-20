<?php

namespace App;

use App\Models\Pen;
use Illuminate\Support\Str;

class Slug
{
    /**
     * Generates a random, unique slug
     */
    public static function generate()
    {
        $slug = Str::random(10);
        $check = Pen::where('slug', $slug)->first();

        if ($check) {
            return static::generate();
        }

        return $slug;
    }
}

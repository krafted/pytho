<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenRequest;
use App\Models\Pen;
use App\Slug;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class PenController extends Controller
{
    /**
     * Show the main Editor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pen           $pen
     * @return \Inertia\Response
     */
    public function show(Request $request, ?Pen $pen = null)
    {
        $isOwner = $pen && $pen->owner->id === optional($request->user())->id;

        return inertia('Pen', [
            'is_owner' => $isOwner,
            'pen' => optional($pen)->only('content', 'slug'),
            'slug' => $isOwner
                ? $pen->slug ?? Slug::generate()
                : Slug::generate(),
        ]);
    }

    /**
     * Attempt to create a new Pen.
     *
     * @param  \App\Http\Requests\PenRequest  $request
     * @return \App\Models\Pen
     */
    public function store(PenRequest $request)
    {
        $pen = $request->user()->pens()->create($request->validated());

        return redirect($pen->path());
    }

    /**
     * Attempt to update an existing Pen.
     *
     * @param  \App\Http\Requests\PenRequest  $request
     * @param  \App\Models\Pen                $pen
     * @return \App\Models\Pen
     */
    public function update(PenRequest $request, Pen $pen)
    {
        $pen->update($request->validated());

        return redirect($pen->path());
    }
}

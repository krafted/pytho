<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenRequest;
use App\Models\Pen;
use App\Slug;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class PenController extends Controller
{
    /**
     * Show the main Editor.
     *
     * @param  \App\Models\Pen  $pen
     * @return \Inertia\Response
     */
    public function show(?Pen $pen = null)
    {
        return inertia('Pen', [
            'pen' => optional($pen)->only('content', 'slug'),
            'slug' => $pen->slug ?? Slug::generate(),
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

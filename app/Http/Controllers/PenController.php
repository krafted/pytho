<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenRequest;
use App\Models\Pen;
use App\Slug;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PenController extends Controller
{
    /**
     * Show the main Editor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pen           $pen
     * @return \Inertia\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, ?Pen $pen = null)
    {
        if ($pen) {
            $this->authorize('view', $pen);
        }

        $isOwner = $pen && $pen->owner->id === optional($request->user())->id;

        return inertia('Pen', [
            'isOwner' => $isOwner,
            'pen' => optional($pen)
                ->only('title', 'description', 'content', 'slug', 'visibility'),
            'slug' => Slug::generate(),
        ]);
    }

    /**
     * Attempt to create a new Pen.
     *
     * @param  \App\Http\Requests\PenRequest  $request
     * @return \App\Models\Pen
     * 
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(PenRequest $request)
    {
        $pen = optional($request->user())->pens()->create($request->validated());

        return redirect($pen->path());
    }

    /**
     * Attempt to update an existing Pen.
     *
     * @param  \App\Http\Requests\PenRequest  $request
     * @param  \App\Models\Pen                $pen
     * @return \App\Models\Pen
     * 
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(PenRequest $request, Pen $pen)
    {
        $this->authorize('update', $pen);

        $pen->update($request->validated());

        return redirect($pen->path());
    }
}

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

        $isCreator = $pen && $pen->creator->id === optional($request->user())->id;

        return auth()->check() || $pen || $request->query('try', false) === null
            ? inertia('Pen', [
                    'isCreator' => $isCreator,
                    'pen' => $pen
                        ? $pen
                            ->load('creator:id,name,username')
                            ->only('title', 'description', 'content', 'comments', 'creator', 'slug', 'visibility')
                        : null,
                    'comments' => $pen
                        ? collect($pen->comments()->with('user:id,name,username,profile_photo_path')->get())
                            ->mapToGroups(function ($comment) {
                                return [
                                    $comment->properties['coords'][0]['line'] => [
                                        'body' => $comment->body,
                                        'created_at' => str_replace(' ago', '', $comment->created_at->shortRelativeToNowDiffForHumans()),
                                        'properties' => $comment->properties,
                                        'user' => $comment->user,
                                    ],
                                ];
                            })
                        : null,
                    'slug' => Slug::generate(),
                ])
            : inertia('Landing');
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

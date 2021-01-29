<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Pen;

class CommentController extends Controller
{
    /**
     * Attempt to create a new Comment on a Pen.
     *
     * @param  \App\Http\Requests\CommentRequest  $request
     * @param  \App\Models\Pen                    $pen
     * @return \App\Models\Pen
     * 
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CommentRequest $request, Pen $pen)
    {
        abort_if(!$request->user(), 403);

        $comment = new Comment($request->validated());
        $comment->user_id = $request->user()->id;

        $pen->comments()->save($comment);

        return redirect($pen->path());
    }
}

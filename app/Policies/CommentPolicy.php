<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Pen;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given comment can be destroyed by the user.
     *
     * @param  \App\Models\User     $user
     * @param  \App\Models\Comment  $comment
     * @param  \App\Models\Pen      $pen
     * @return bool
     */
    public function destroy(User $user, Comment $comment, Pen $pen)
    {
        $userId = optional($user)->id;

        return $userId === $pen->user_id || $userId == $comment->user_id;
    }
}

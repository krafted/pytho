<?php

namespace App\Policies;

use App\Models\Pen;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create a pen.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine if the given pen can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pen   $pen
     * @return bool
     */
    public function update(User $user, Pen $pen)
    {
        return $user->id === $pen->user_id;
    }
}

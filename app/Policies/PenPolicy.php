<?php

namespace App\Policies;

use App\Models\Pen;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pen   $pen
     * @return mixed
     */
    public function view(?User $user, Pen $pen)
    {
        return optional($user)->id === $pen->user_id || in_array($pen->visibility, ['public', 'unlisted']);
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
        return optional($user)->id === $pen->user_id;
    }

    /**
     * Determine if the given pen can be destroyed by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pen   $pen
     * @return bool
     */
    public function destroy(User $user, Pen $pen)
    {
        return optional($user)->id === $pen->user_id;
    }
}

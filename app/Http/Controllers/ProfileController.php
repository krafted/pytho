<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProfileController extends Controller
{
    /**
     * Show pens this user has created.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User          $user
     * @param  \Illuminate\Support\Str   $visibility
     * @return \Inertia\Response
     */
    public function show(Request $request, User $user, $visibility = 'public')
    {
        abort_if(in_array($visibility, ['private', 'unlisted']) &&
                 optional($request->user())->id !== $user->id, 403);

        return inertia('Profile', [
            'profile' => $user,
            'pens' =>
                $user
                    ->pens()
                    ->ofVisibility($visibility)
                    ->latest('updated_at')
                    ->get()
                    ->map(function ($pen) {
                        return [
                            'title' => $pen->title,
                            'slug' => $pen->slug,
                            'description' => $pen->description,
                            'updated_at' => $pen->updated_at->diffForHumans(),
                        ];
                    }),
        ]);
    }
}

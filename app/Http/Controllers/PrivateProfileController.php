<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PrivateProfileController extends Controller
{
    /**
     * Show private pens this user has created.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User          $user
     * @return \Inertia\Response
     */
    public function show(Request $request, User $user)
    {
        return inertia('Profile', [
            'profile' => $user,
            'pens'    =>
                $user
                    ->pens()
                    ->private()
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

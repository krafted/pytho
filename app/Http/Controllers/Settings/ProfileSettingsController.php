<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class ProfileSettingsController
{
    /**
     * Show the profile settings screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function show(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Settings/Profile/Show');
    }
}

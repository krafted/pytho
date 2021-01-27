<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class SecuritySettingsController
{
    /**
     * Show the security settings screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function show(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Settings/Security/Show');
    }
}

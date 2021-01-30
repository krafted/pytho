<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class LandingController extends Controller
{
    /**
     * Show the landing page.
     *
     * @return \Inertia\Response
     */
    public function show()
    {
        return inertia('Landing');
    }
}

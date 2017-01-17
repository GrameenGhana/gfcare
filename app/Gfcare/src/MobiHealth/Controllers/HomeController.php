<?php

namespace App\Gfcare\src\MobiHealth\Controllers;

use App\Gfcare\Core\BaseController;

class HomeController extends BaseController
{

    /**
     * Show the terms of service for the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $team = $this->user->teams()->findOrFail(3);
        $activeTab = 'welcome';
        return view('MobiHealth::home', compact('team', 'activeTab'));
    }
}

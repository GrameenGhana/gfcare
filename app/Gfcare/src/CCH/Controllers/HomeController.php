<?php

namespace App\Gfcare\src\CCH\Controllers;

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
        $team = $this->user->teams()->findOrFail($this->user->current_team_id); 
        $activeTab = $this->firstTabKey($team, $this->user);
        return view('CCH::home', compact('team', 'activeTab'));
    }
}

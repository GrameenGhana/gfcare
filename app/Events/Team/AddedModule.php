<?php

namespace App\Events\Team;

use App\Teams\Module;
use App\Teams\Team;
use Illuminate\Queue\SerializesModels;

class AddedModule
{
    use SerializesModels;

    /**
     * The module instance.
     *
     * @var \App\Teams\Module 
     */
    public $module;

    /**
     * The team instance.
     *
     * @var \App\Teams\Team
     */
    public $team;

    /**
     * Create a new event instance.
     *
     * @param  \App\Teams\Module  $module
     * @param  \App\Teams\Team $team
     *
     * @return void
     */
    public function __construct(Module $module, Team $team)
    {
        $this->module = $module;
        $this->team = $team;
    }
}

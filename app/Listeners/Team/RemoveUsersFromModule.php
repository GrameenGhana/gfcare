<?php

namespace App\Listeners\Team;

use App\Events\Team\RemovedModule;

class RemoveUsersFromModule
{
    public function __construct()
    {
    }

    public function handle(RemovedModule $event)
    {
        $event->module->users()->detach();
    }
}

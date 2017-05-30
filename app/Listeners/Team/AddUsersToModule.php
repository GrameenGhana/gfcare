<?php

namespace App\Listeners\Team;

use App\Events\Team\AddedModule;
use Illuminate\Support\Facades\Log;

class AddUsersToModule
{
    public function __construct()
    {
    }

    public function handle(AddedModule $event)
    {
        // Add project system users to module
        $users = $event->team->users()->sys()->get();
  
        foreach($users as $u) {
            $role = $u->teamRole($event->team);
            $editor = in_array($role, array('owner','editor')) ? 1 : 0;
            $u->joinModuleById($event->team->id, $event->module->id, $role, $editor);
        }
    }
}

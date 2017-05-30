<?php

namespace App\Gfcare\src\Noyawa\Models;

use App\Ux\Settings\Tab;
use App\Ux\Settings\Tabs;
use App\Gfcare\Core\TabGroup;

class ModuleTabs extends Tabs
{
    private $tabGroups = [];
 
    public function setTabGroups() 
    { 
        array_push($this->tabGroups, new TabGroup('System',true,true));
        return $this->tabGroups; 
    }

    // Dashboard
    public function dashboard() { 
        return [ 
                new Tab('Indicators', 'Noyawa::dashboard', 'fa-dashboard',
                    function ($team, $user) { return $user->belongsToModule($team); }),
                new Tab('Clients', 'Noyawa::clients.client', 'fa-group',
                    function ($team, $user) { return $user->belongsToModule($team); }) 
        ]; 
    }

    // System
    public function system()
    {
        return [
                new Tab('Users', 'Noyawa::system.user', 'fa-users',
                    function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[0]->name),
        ];
    }
}

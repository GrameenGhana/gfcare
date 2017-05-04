<?php

namespace App\Gfcare\src\MobileMidwife\Models;

use App\Ux\Settings\Tab;
use App\Ux\Settings\Tabs;
use App\Gfcare\Core\TabGroup;

class ModuleTabs extends Tabs
{
    private $tabGroups = [];
 
    public function setTabGroups() 
    { 
        array_push($this->tabGroups, new TabGroup('Service',true,true));
        array_push($this->tabGroups, new TabGroup('System',true,true));
        return $this->tabGroups; 
    }

    // Dashboard
    public function dashboard() { 
        return [ 
                new Tab('Indicators', 'MobileMidwife::dashboard', 'fa-dashboard',
                    function ($team, $user) { return $user->belongsToModule($team); }),

                new Tab('Subscribers', 'MobileMidwife::service.client', 'fa-group',
                    function ($team, $user) { return $user->belongsToModule($team); }), 

                new Tab('Subscriptions', 'MobileMidwife::service.subscription', 'fa-list',
                    function ($team, $user) { return $user->belongsToModule($team); }), 

        ]; 
    }

    // Content
    public function service()
    {
        return [
                new Tab('Campaigns', 'MobileMidwife::service.campaign', 'fa-bullhorn', 
                    function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[0]->name),
            
                new Tab('Programs', 'MobileMidwife::service.program', 'fa-comment', 
                    function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[0]->name),

                new Tab('Content', 'MobileMidwife::service.content', 'fa-file-text-o', 
                    function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[0]->name)
        ];
    }
    

    // System
    public function system()
    {
        return [
                new Tab('Configuration', 'MobileMidwife::system.config', 'fa-gears',
                    function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[1]->name),

                new Tab('Users', 'MobileMidwife::system.user', 'fa-users',
                    function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[1]->name),
        ];
    }
}

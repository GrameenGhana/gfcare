<?php

namespace App\Gfcare\src\CCH\Models;

use App\Ux\Settings\Tab;
use App\Ux\Settings\Tabs;
use App\Gfcare\Core\TabGroup;


class ModuleTabs extends Tabs
{
    private $tabGroups = [];
 
    public function setTabGroups() 
    { 
        array_push($this->tabGroups, new TabGroup('Content', true));
        //array_push($this->tabGroups, new TabGroup('Targets'));
        array_push($this->tabGroups, new TabGroup('System',true,true));
        return $this->tabGroups; 
    }

    // Dashboard
    public function dashboard() { 
        return [ 
                new Tab('Indicators', 'settings.team.tabs.owner', 'fa-dashboard',
                    function ($team, $user) { return $user->belongsToModule($team); }),
            
              //  new Tab('Reports', 'settings.team.tabs.owner', 'fa-bar-chart-o',
                //    function ($team, $user) { return $user->belongsToModule($team); }) 
        ]; 
    }

    // Content
    public function content()
    {
        return [
                new Tab('Point of Care', 'CCH::content.poc', 'fa-stethoscope', 
                    function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[0]->name),
            
                new Tab('Learning Center', 'CCH::content.reference', 'fa-graduation-cap', 
                    function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[0]->name)
        ];
    }
    

    /* Targets
    public function targets()
    {
        return [ 
            new Tab('Set Actuals', 'settings.team.tabs.module', 'fa-bullseye', 
                function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[1]->name),

            new Tab('Set Population Targets', 'settings.team.tabs.module', 'fa-line-chart', 
                function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[1]->name)
        ];
    }
    */
    
    // System
    public function system()
    {
        return [
            new Tab('Devices', 'CCH::system.device', 'fa-mobile-phone', 
                function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[1]->name),
            
            new Tab('Roles', 'CCH::system.role', 'fa-sitemap', 
                function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[1]->name),

            new Tab('Users', 'CCH::system.user', 'fa-users', 
                function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[1]->name)
        ];
    }
}
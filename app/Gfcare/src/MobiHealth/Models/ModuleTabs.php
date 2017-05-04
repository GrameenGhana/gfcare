<?php

namespace App\Gfcare\src\MobiHealth\Models;

use App\Ux\Settings\Tab;
use App\Ux\Settings\Tabs;
use App\Gfcare\Core\TabGroup;

class ModuleTabs extends Tabs
{
    private $tabGroups = [];
 
    public function setTabGroups() 
    {
        array_push($this->tabGroups, new TabGroup('Groups'));
        array_push($this->tabGroups, new TabGroup('Content', true));
        array_push($this->tabGroups, new TabGroup('System',true,true));
        return $this->tabGroups; 
    }

    // Dashboard
    public function dashboard() { 
        return [ 
             new Tab('Welcome', 'MobiHealth::welcome', 'fa-home',
                    function ($team, $user) { return $user->belongsToModule($team); }),
            
             new Tab('Indicators', 'MobiHealth::dashboard', 'fa-dashboard',
                    function ($team, $user) { return $user->belongsToModule($team); }),
        ]; 
    }
/*
    // Group
    public function groups()
    {
        return [
                new Tab('Report', 'MobiHealth::group.report', 'fa-file-text-o', 
                    function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[0]->name),
            
                new Tab('Groups', 'MobiHealth::group.group', 'fa-group', 
                    function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[0]->name),
                    
        ];
    }
    
    
    // Content
    public function content()
    {
        return [
                new Tab('Audio Content', 'MobiHealth::content.audio', 'fa-file-audio-o', 
                    function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[1]->name),
            
                new Tab('Visual Aids', 'MobiHealth::content.visualaid', 'fa-file-text-o', 
                    function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[1]->name),
        ];
    }
 */  
    // System
    public function system()
    {
        return [            
            new Tab('Referral Mapping', 'MobiHealth::system.referral', 'fa-exchange', 
                function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[2]->name),

            new Tab('Users', 'MobiHealth::system.user', 'fa-users', 
                function ($team, $user) { return $user->belongsToModule($team); }, $this->tabGroups[2]->name)
        ];
    }
}

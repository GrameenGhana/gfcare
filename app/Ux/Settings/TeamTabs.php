<?php

namespace App\Ux\Settings;

class TeamTabs extends Tabs
{
    /**
     * Get the tab configuration for the "Owner Settings" tab.
     *
     * @return \App\Ux\Settings\Tab
     */
    public function owner()
    {
        return new Tab('Basic Settings', 'settings.team.tabs.owner', 'fa-star', function ($team, $user) {
            return $user->ownsTeam($team);
        });
    }

    /**
     * Get the tab configuration for the "Membership" tab.
     *
     * @return \App\Ux\Settings\Tab
     */
    public function membership()
    {
        return new Tab('Membership', 'settings.team.tabs.membership', 'fa-users');
    }
    
    /**
     * Get the tab configuration for the "Modules" tab.
     *
     * @return \App\Ux\Settings\Tab
     */
    public function module()
    {
        return new Tab('Module Settings', 'settings.team.tabs.module', 'fa-gears', function ($team, $user) {
            return $user->ownsTeam($team);
        });
    }
    
    /**
     * Get the tab configuration for the "Location" tab.
     *
     * @return \App\Ux\Settings\Tab
     */
    public function location()
    {
        return new Tab('Location Settings', 'settings.team.tabs.location', 'fa-map-marker', function ($team, $user) {
            return $user->ownsTeam($team);
        });
    }
}

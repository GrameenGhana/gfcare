<?php

namespace App;

use App\Teams\Team as BaseTeam;
use App\Teams\Module;
use App\Teams\Location;
use App\Teams\Facility;
use App\Teams\FacilityGroup;

class Team extends BaseTeam
{
    /**
     * Get all of the modules for the team.
     */
    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('menu_name', 'asc');
    }
    
     /**
     * Check if team has a module
     *
     * @param  string  $moduleId
     * @return boolean
     */
    public function hasModule($moduleId)
    {
        $module = $this->modules()->where('module_id', $moduleId)->first();
        return ($module) ? true: false;
    }
    
    /**
     * Add a module to the team 
     *
     * @param  string  $moduleId
     * @param  string  $menu_name
     * @param  string  $menu_slug
     * @return \App\Teams\Module
     */
    public function addModule($moduleId, $menu_name, $menu_slug)
    {
        $module = $this->modules()->where('module_id', $moduleId)->first();

        if (! $module) {
            $menu_slug = ($this->startsWith($menu_slug, '/')) ? $menu_slug : '/'.$menu_slug; 
            $menu_slug = ($this->endsWith($menu_slug, '/')) ? $menu_slug : $menu_slug.'/'; 
            $module = $this->modules()->create([ 'module_id' => $moduleId, 'menu_name'=>$menu_name, 'menu_slug'=>$menu_slug]);
        }

        return $module;
    }
     
    /**
     * Toggle team module status 
     *
     * @param int  $moduleId
     * @return \App\Teams\Module
     */
    public function toggleModuleStatus($moduleId)
    {
        $module = $this->modules()->where('id', $moduleId)->first();
        if ($module) { $module->toggleStatus();  }
        return $module;
    }
    
    /**
     * Remove a module from the team 
     *
     * @param  string  $moduleId
     * @return boolean
     */
    public function removeModule($moduleId)
    {
        $module = $this->modules()->where('id', $moduleId)->first();
        if ($module) { $module->delete();  return true; }
        return false;
    }
    

    
    
    
    /**
     * Get all of the locations for the team.
     */
    public function locations()
    {
        return $this->hasMany(Location::class)->orderBy('type', 'asc')->orderBy('name');
    }
    
    /**
     * Add a location to the team 
     *
     * @param  int  $parentId
     * @param  string  $type
     * @param  string  $name
     * @param  int  $level
     * @return \App\Teams\Location
     */
    public function addLocation($parentId, $type, $name, $level)
    {
        $location = $this->locations()->whereRaw("parent_id=? and type=? and LOWER(name)=? and level=?",
                                       array($parentId,$type,strtolower($name),$level))->first();

        if (! $location) {
            $location = $this->locations()->create([ 'parent_id' => $parentId, 'type'=>$type, 'name'=>$name, 'level'=>$level]);
        }

        return $location;
    }    
    
    
    /**
     * Get all of the facilities for the team.
     */
    public function facilities()
    {
        return $this->hasMany(Facility::class)->orderBy('location_id')->orderBy('type', 'asc')->orderBy('name');
    }
    
    /**
     * Get all of the facilitygroup for the team.
     */
    public function facilitygroups()
    {
        return $this->hasMany(FacilityGroup::class)->orderBy('type', 'asc')->orderBy('name');
    }
    
   
    
    
    
    protected function startsWith($haystack, $needle)
    {
        return substr_compare($haystack, $needle, 0, strlen($needle))  === 0;
    }
    
    protected function endsWith($haystack, $needle)
    {
        return substr_compare($haystack, $needle, -strlen($needle))  === 0;
    }     
}

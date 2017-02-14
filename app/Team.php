<?php

namespace App;

use App\Teams\Team as BaseTeam;
use App\Teams\Module;
use App\Teams\Location;
use App\Teams\Tracker;
use App\Teams\Facility;
use App\Teams\FacilityGroup;
use App\Teams\Device;
use App\Teams\ProjectUser;

class Team extends BaseTeam
{
    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('menu_name', 'asc');
    }
    
    public function hasModule($moduleId)
    {
        $module = $this->modules()->where('module_id', $moduleId)->first();
        return ($module) ? true: false;
    }
    
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
     
    public function toggleModuleStatus($moduleId)
    {
        $module = $this->modules()->where('id', $moduleId)->first();
        if ($module) { $module->toggleStatus();  }
        return $module;
    }
    
    public function removeModule($moduleId)
    {
        $module = $this->modules()->where('id', $moduleId)->first();
        if ($module) { $module->delete();  return true; }
        return false;
    }
    
    
    public function tracker()
    {
        return $this->hasMany(Tracker::class);
    }


    public function locations()
    {
        return $this->hasMany(Location::class)->orderBy('type', 'asc')->orderBy('name');
    }
    
    public function addLocation($parentId, $type, $name, $level)
    {
        $location = $this->locations()->whereRaw("parent_id=? and type=? and LOWER(name)=? and level=?",
                                       array($parentId,$type,strtolower($name),$level))->first();

        if (! $location) {
            $location = $this->locations()->create([ 'parent_id' => $parentId, 'type'=>$type, 'name'=>$name, 'level'=>$level]);
        }

        return $location;
    }    
    
    public function facilities()
    {
        return $this->hasMany(Facility::class)->orderBy('location_id')->orderBy('type', 'asc')->orderBy('name');
    }
    
    public function facilitygroups()
    {
        return $this->hasMany(FacilityGroup::class)->orderBy('type', 'asc')->orderBy('name');
    }
    
   
    public function devices()
    {
        return $this->hasMany(Device::class)->orderBy('imei', 'asc')->orderBy('type');
    }
    
    public function projectusers()
    {
        return $this->belongsToMany(ProjectUser::class,'user_teams','team_id','user_id')->where('user_type','User')->orderBy('name', 'asc');
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

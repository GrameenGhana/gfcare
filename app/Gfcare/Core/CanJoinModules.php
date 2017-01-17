<?php

namespace App\Gfcare\Core;

use App\Spark;
use App\Teams\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


trait CanJoinModules
{   
    protected function getArrayableAppends()
    {
        $this->appends = array_merge($this->appends, ['role','editor']);
        return parent::getArrayableAppends();
    }
    
    public function getRoleAttribute()
    {
        return $this->moduleRole();
    }
    
    public function getEditorAttribute()
    {
        return $this->moduleRoleCanEdit();
    }
    
    public function module()
    {
        return $this->modules();
    }

    public function modules()
    {
        return $this->belongsToMany(Spark::model('modules', Module::class), 'user_modules', 'user_id')->withPivot(['role','editor']);
    }
     
    public function allusers()
    {
        return $this->currentModule()->users(); 
    }
    
    public function clients()
    {
        return $this->currentModule()->users()->client(); 
    }
    
    public function sysusers()
    {
        return $this->currentModule()->users()->sys(); 
    }
    
    
    public function hasModules()
    {
        return count($this->modules) > 0;
    }
      
    public function belongsToModule($team)
    {    
        return $this->modules->where('id',$this->currentModule()->id)->count() > 0;
    }

    public function joinModuleById($teamId, $moduleId, $role, $editor=0)
    {
        $this->modules()->attach($moduleId, ['team_id'=>$teamId, 'role' => $role, 'editor'=>$editor]);
    }

    public function currentModule()
    {
        $user = Auth::user();
        if ((is_null($user->current_module_id) || $user->current_module_id==0) && $user->hasModules()) {
            $this->switchToModule($this->activeModule());
            return $this->currentModule();
        } elseif (! is_null($user->current_module_id)) {
            $currentModule = \App\Teams\Module::find($user->current_module_id);
            return $currentModule ?: $this->refreshCurrentModule();
        }
    }
    
    public function activeModule()
    {
        foreach($this->modules as $m) {
            if ($m->active==1) {
                return $m;
            }
        }
        return null;
    }

    public function switchToModule($module)
    {
        $this->current_module_id = $module->id;
        $this->save();
    }
    
    public function refreshCurrentModule()
    {
        $this->current_module_id = null;
        $this->save();
        $this->currentModule();
    }

    public function moduleRole()
    {        
        $cmod = $this->currentModule();   
        if (!is_null($cmod)) {
            foreach($this->modules as $mod) {
                if ($mod->id == $cmod->id) {
                    return $mod->pivot->role;
                }
            }
        }
        return null;
    }
    
    public function moduleRoleCanEdit()
    {
        $cmod = $this->currentModule();
        
        if (!is_null($cmod)) {
            foreach($this->modules as $mod) {
                if ($mod->id == $cmod->id) {
                    return $mod->pivot->editor==1;
                }
            }
        }   
        return 0;
    }
}

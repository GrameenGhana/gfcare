<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;
 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Exception;

use App\Teams\Module;

class UsersModuleScope implements ScopeInterface
{
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();
        if ($user) {
            $module = $this->getCurrentModule();
            if (!is_null($module)) {
                $userIds = $module->users->pluck('id');
                $builder->whereIn('id', $userIds);
            }
        } 
    }

    private function getCurrentModule()
    {
        $slug = '/'.$this->getCurrentModuleSlug().'/';
        $module = Module::whereRaw('menu_slug=?',array($slug))->first(); 
        return ($module) ? $module : null;
    }

    private function getCurrentModuleSlug($path=null)
    {
        $currentPath = Route::getFacadeRoot()->current()->uri();
        $parts = explode('/',$currentPath);
        $slug = ($path==null) ? $parts[0] : $path;
        return $slug;
    }
}


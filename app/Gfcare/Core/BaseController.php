<?php

namespace App\Gfcare\Core;

use Exception;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Spark;
use View;

class BaseController extends Controller
{
    private $tabs = null;
    private $tabGroups = null;
    
    protected $user = null;
    private $module = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($module=null)
    {
        $this->middleware('auth');
        $this->module = $this->getModulePath($module);    
        $this->user = \Auth::user();
        
        $this->tabs = $this->setUpTabs();
        
        View::share('tabs', $this->tabs);
        View::share('tabgroups', $this->tabGroups);        
        View::share('user', $this->user);
    }
    
    public function firstTabKey($team, $user) 
    {
        return (count($this->tabs->displayable($team, $user))>0) ? $this->tabs->displayable($team, $user)[0]->key : '';
    }
    
    private function setUpTabs() 
    {
        $tabs = [];
        $avoid = ['__construct', 'configure','make','displayable','getTabGroups','setTabGroups'];
        $class = 'App\Gfcare\src\\'.$this->module.'\Models\ModuleTabs';
        
        $x = (new $class);
        $this->tabGroups = $x->setTabGroups();
                    
        $methods = $this->getModuleTabMethods();
        foreach($methods as $m) {
            $method = $m->name;
            if (!in_array($method, $avoid)) {
                $tabs = array_merge($tabs, $x->$method());
            }
        }
        
        return new $class($tabs);
    }
    
    private function getModulePath($path=null)
    {
        $currentPath = Route::getFacadeRoot()->current()->uri();
        $path = ($path==null) ? Spark::getModulePath($currentPath) : $path;
        if($path==null || !file_exists(__DIR__.'/../src/'.$path.'/routes.php')) {
           throw new Exception("Module path [$path] not found.");        
        }
        return $path;
    }

    private function getModuleTabMethods()
    {
        $class = new \ReflectionClass('App\Gfcare\src\\'.$this->module.'\Models\ModuleTabs');
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        return $methods;
    }
}

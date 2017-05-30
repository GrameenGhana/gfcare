<?php

namespace App\Http\Controllers\Settings;

use Exception;
use App\Spark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Events\Team\AddedModule as ModuleCreated;
use App\Events\Team\RemovedModule as ModuleRemoved;
use App\Contracts\Repositories\TeamRepository;

class ModuleController extends Controller
{
    /**
     * The team repository instance.
     *
     * @var \App\Contracts\Repositories\TeamRepository
     */
    protected $teams;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Contracts\Repositories\TeamRepository  $teams
     * @return void
     */
    public function __construct(TeamRepository $teams)
    {
        $this->teams = $teams;
        $this->middleware('auth');
    }

    /**
     * Create new module.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $teamId)
    {
        $user = $request->user();
        
        $team = $user->teams()
                ->where('owner_id', $user->id)
                ->findOrFail($teamId);

        if (! $team->modules()->where('module_id', $request->id)->exists()) {
            $module = $team->addModule($request->id, $request->menu_name, $request->menu_slug);
            event(new ModuleCreated($module, $team));
        }

        return $team->fresh($this->teamWith);
    }
    
    /**
     * Toggle module status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @param  int  $moduleId
     * @return \Illuminate\Http\Response
     */
    public function toggleModuleStatus(Request $request, $teamId, $moduleId)
    {
        $user = $request->user();
        
        $team = $user->teams()
                ->where('owner_id', $user->id)
                ->findOrFail($teamId);

        if ($team->modules()->where('id', $moduleId)->exists()) {
            $module = $team->toggleModuleStatus($moduleId);
        }
        return $team->fresh($this->teamWith);
    }

    /**
     * Destroy the given module.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @param  int  $moduleId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $teamId, $moduleId)
    {
        $user = $request->user();
        
        $team = $user->teams()
                ->where('owner_id', $user->id)
                ->findOrFail($teamId);

        if ($team->modules()->where('id', $moduleId)->exists()) {
            $module = $team->modules()->where('id', $moduleId)->first();
            if ($team->removeModule($moduleId)) {
                event(new ModuleRemoved($module, $team));
            }
        }
        
        return $team->fresh($this->teamWith);
    }
}

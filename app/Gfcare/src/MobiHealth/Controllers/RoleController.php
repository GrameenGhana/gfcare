<?php

namespace App\Gfcare\src\MobiHealth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\GfCare\src\MobiHealth\Models\Role;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \App\Contracts\Repositories\RoleRepository  $roles
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show roles for current team and module.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return response()->json($this->getRoles());
    }
    
    public function getUsers(Request $request, $role) 
    {
        $r = Role::where('name',$role)->first();
        return response()->json($r->users());
    }

    /**
     * Create a new role.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        
        $this->validate($request, ['name' => 'required|max:255']);

        $role = Role::where('name',$request->name)->first();

        if(!$role) {
            $role = new Role();
            $role->name = $request->name;
            $role->team_id = $user->current_team_id;
            $role->is_editor = $request->is_editor;
            $role->save();
        }
        
        return $this->getRoles(); 
    }

    /**
     * Update the role's owner information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $roleId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $this->validate($request, [ 'name' => 'required|max:255', ]);
        
        if ($request->name != $role->name || $request->is_editor != $role->is_editor) {
            $role->updateUserModuleRole($request->name, $request->is_editor);
        }
        
        $role->fill(['name' => $request->name, 'is_editor'=>$request->is_editor])->save();
        return $role; 
    }

    /**
     * Destroy the given role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $roleId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);         
        $role->updateUserModuleRole('invalid', 0);
        $role->delete();
        return $this->getRoles(); 
    }

    /**
     * Show roles for current team and module.
     *
     * @return \App\Gfcare\src\MobiHealth\Models\Role
     */
    private function getRoles()
    {
        return Role::orderBy('name')->get();
    }
}
